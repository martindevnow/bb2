<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckAllActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:actions {dir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for all actions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = $this->argument('dir');
        $actions = $this->scanDirectory($dir);
        $dups = array_filter($actions, function ($action) {
            return $action > 1;
        });
        dd ($dups);
    }

    private function scanDirectory($dir) {
        $this->info('Scanning '. $dir . '...');

        $filesAndFolders = array_filter(
            scandir($dir),
            function ($forf) {
                if (strpos($forf, '.') === 0)
                    return false;
                return true;
            }
        );

        $actionFiles = array_filter($filesAndFolders, function($forf) {
            $actionLoc = strpos($forf, '.actions.ts');
            $testLoc = strpos($forf, 'test');
            return !! $actionLoc &&
                ($testLoc === false || $testLoc < $actionLoc );
        });

        $directories = array_filter($filesAndFolders, function($forf) use ($dir) {
            $filePath = $dir . '/' . $forf;
            return file_exists($filePath) &&
                ! is_file($filePath);
        });

        $this->info('  Found ' . count($filesAndFolders) . ' ... (' . count($actionFiles) . ' actions & ' . count($directories) . ' folders)');

        $actions = [];

        // Scan any actions encountered so far
        foreach ($actionFiles as $actionFile) {
            $actions = $this->array_sum_identical_keys($actions, $this->scanForActions($dir . '/' . $actionFile));
        }

        // Run Recursively
        foreach ($directories as $directory) {
            if (is_array($dir))
                dd('dir', $dir);
            if (is_array($directory))
                dd('directory', $directory);

            $actions = $this->array_sum_identical_keys($actions, $this->scanDirectory($dir . '/' .$directory));
        }

        return $actions;

    }

    private function scanForActions($filePath) {
        $this->info('    Scanning ' . $filePath . ' for specific actions...');
        $expression = "|static [A-Z_]+ = '([A-Z_]+)';|U";
        $fileContents = file_get_contents($filePath);
        preg_match_all($expression, $fileContents, $out);

        if ($out && is_array($out) && count($out) && count($out[1])) {
            return array_map(
                function ($item) {
                    return 1;
                },
                array_flip($out[1]));
        }
    }

    private function array_sum_identical_keys($a1, $a2) {
        $sums = array();
        foreach (array_keys($a1 + $a2) as $key) {
            $sums[$key] = (isset($a1[$key]) ? $a1[$key] : 0) + (isset($a2[$key]) ? $a2[$key] : 0);
        }
        return $sums;
    }
}
