@extends('layouts.material.app')

@section('content')


    {{--<div class="material-background"></div>--}}

    <div class="ms-hero-page-override ms-hero-img-farm ms-hero-bg-primary">
        <div class="container">
            <div class="text-center">
                {{--<span class="ms-logo ms-logo-lg ms-logo-white center-block mb-2 mt-2 animated zoomInDown animation-delay-5">BB</span>--}}
                <h1 class="no-m ms-site-title color-white center-block ms-site-title-lg mt-2 animated zoomInDown animation-delay-5">B.A.R.F.
                    <span>Bento</span>
                </h1>
                <p class="lead lead-lg color-white text-center center-block mt-2 mw-800 text-uppercase fw-300 animated fadeInUp animation-delay-7">Enter the compelling
                    <span class="color-warning">motto</span> of B.A.R.F. Bento here!</p>
            </div>
        </div>
    </div>

    <div class="container container-full">
        <div class="ms-paper" style="position: relative; top: -100px;">
            <div class="row">
                <div class="col-md-12 ms-paper-content-container">
                    <div class="ms-paper-content">
                        <h1>Quote</h1>
                        <section class="ms-component-section">
                            <h2 class="section-title">Fill in all fields</h2>
                            <div class="alert alert-info">
                                <p>
                                    <i class="zmdi zmdi-info-outline"></i> Simply fill out the fields below to get your
                                    <strong>quote</strong> to being the B.A.R.F. diet</p>
                            </div>


                            <quotes-calculator></quotes-calculator>





                            <form class="form-horizontal">
                                <fieldset>
                                    <legend>Legend</legend>
                                    <div class="form-group is-empty">
                                        <label for="inputEmail" class="col-md-2 control-label">Email</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" id="inputEmail" placeholder="Email"> </div>
                                    </div>
                                    <div class="form-group is-empty">
                                        <label for="inputPassword" class="col-md-2 control-label">Password</label>
                                        <div class="col-md-10">
                                            <input type="password" class="form-control" id="inputPassword" placeholder="Password"> </div>
                                    </div>
                                    <div class="form-group" style="margin-top: 0;">
                                        <!-- inline style is just to demo custom css to put checkbox below input above -->
                                        <div class="col-md-offset-2 col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"><span class="checkbox-material"><span class="check"></span></span> Checkbox </label>
                                                <label>
                                                    <input type="checkbox" disabled=""><span class="checkbox-material"><span class="check"></span></span> Disabled Checkbox </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-10">
                                            <div class="togglebutton">
                                                <label>
                                                    <input type="checkbox" checked=""><span class="toggle"></span> Toggle button </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group is-empty is-fileinput">
                                        <label for="inputFile" class="col-md-2 control-label">File</label>
                                        <div class="col-md-10">
                                            <input type="text" readonly="" class="form-control" placeholder="Browse...">
                                            <input type="file" id="inputFile" multiple=""> </div>
                                    </div>
                                    <div class="form-group is-empty">
                                        <label for="textArea" class="col-md-2 control-label">Textarea</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" rows="3" id="textArea"></textarea>
                                            <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Radios</label>
                                        <div class="col-md-10">
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked=""><span class="circle"></span><span class="check"></span> Option one is this </label>
                                            </div>
                                            <div class="radio radio-primary">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"><span class="circle"></span><span class="check"></span> Option two can be something else </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="select111" class="col-md-2 control-label">Select</label>
                                        <div class="col-md-10">
                                            <div class="btn-group bootstrap-select form-control">
                                                <select id="select111" class="form-control selectpicker" data-dropup-auto="false" tabindex="-98">
                                                    <option>Ea nam qui vel consequatur</option>
                                                    <option>Dolorem perspiciatis adipisci </option>
                                                    <option>Aperiam, debitis deleniti</option>
                                                    <option>Accusamus non qui amet eum</option>
                                                    <option>Doloremque commodi impedit</option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="select222" class="col-md-2 control-label">Select Multiple</label>
                                        <div class="col-md-10">
                                            <div class="btn-group bootstrap-select show-tick form-control">
                                                {{--<button type="button" class="btn dropdown-toggle bs-placeholder btn-default" data-toggle="dropdown" role="button" data-id="select222" title="Nothing selected">--}}
                                                    {{--<span class="filter-option pull-left">Nothing selected</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>--}}
                                                {{--<div class="dropdown-menu open" role="combobox">--}}
                                                    {{--<ul class="dropdown-menu inner" role="listbox" aria-expanded="false">--}}
                                                        {{--<li data-original-index="0"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Ea nam qui vel consequatur</span>--}}
                                                                {{--<span class="glyphicon glyphicon-ok check-mark"></span></a></li>--}}
                                                        {{--<li data-original-index="1"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Dolorem perspiciatis adipisci </span>--}}
                                                                {{--<span class="glyphicon glyphicon-ok check-mark"></span></a></li>--}}
                                                        {{--<li data-original-index="2"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Aperiam, debitis deleniti</span>--}}
                                                                {{--<span class="glyphicon glyphicon-ok check-mark"></span></a></li>--}}
                                                        {{--<li data-original-index="3"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Accusamus non qui amet eum</span>--}}
                                                                {{--<span class="glyphicon glyphicon-ok check-mark"></span></a></li>--}}
                                                        {{--<li data-original-index="4"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Doloremque commodi impedit</span>--}}
                                                                {{--<span class="glyphicon glyphicon-ok check-mark"></span></a></li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                                <select id="select222" multiple="" class="selectpicker form-control" data-dropup-auto="false" tabindex="-98">
                                                    <option>Ea nam qui vel consequatur</option>
                                                    <option>Dolorem perspiciatis adipisci </option>
                                                    <option>Aperiam, debitis deleniti</option>
                                                    <option>Accusamus non qui amet eum</option>
                                                    <option>Doloremque commodi impedit</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group is-empty">
                                        <label for="datePicker" class="col-md-2 control-label">Date Picker</label>
                                        <div class="col-md-10">
                                            <input id="datePicker" type="text" class="form-control"> </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-2">
                                            <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                                            <button type="button" class="btn btn-danger">Cancel</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </section>
                        <section class="ms-component-section">
                            <h2 class="section-title">More Options</h2>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label" for="focusedInput1">Write something to make the label float</label>
                                <input class="form-control" id="focusedInput1" type="text"> </div>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label" for="focusedInput2">Focus to show the help-block</label>
                                <input class="form-control" id="focusedInput2" type="text">
                                <p class="help-block">You should really write something here</p>
                            </div>
                            <div class="form-group is-empty">
                                <label class="control-label" for="disabledInput">Disabled input</label>
                                <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled=""> </div>
                            <div class="form-group has-warning is-empty">
                                <label class="control-label" for="inputWarning">Input warning</label>
                                <input type="text" class="form-control" id="inputWarning"> </div>
                            <div class="form-group has-error is-empty">
                                <label class="control-label" for="inputError">Input error</label>
                                <input type="text" class="form-control" id="inputError"> </div>
                            <div class="form-group has-success is-empty">
                                <label class="control-label" for="inputSuccess">Input success</label>
                                <input type="text" class="form-control" id="inputSuccess"> </div>
                            <div class="form-group form-group-lg is-empty">
                                <label class="control-label" for="inputLarge">Large input</label>
                                <input class="form-control" type="text" id="inputLarge"> </div>
                            <div class="form-group is-empty">
                                <label class="control-label" for="inputDefault">Default input</label>
                                <input type="text" class="form-control" id="inputDefault"> </div>
                            <div class="form-group form-group-sm is-empty">
                                <label class="control-label" for="inputSmall">Small input</label>
                                <input class="form-control" type="text" id="inputSmall"> </div>
                            <div class="form-group is-empty">
                                <label class="control-label" for="addon1">Default label w/input addons</label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" id="addon1" class="form-control">
                                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button">Button</button>
                      </span>
                                </div>
                            </div>
                            <div class="form-group label-floating is-empty">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <label class="control-label" for="addon3a">Floating label w/2 addons</label>
                                    <input type="text" id="addon3a" class="form-control">
                                    <p class="help-block">The label is inside the <code>input-group</code> so that it is positioned properly as a placeholder.</p>
                                    <span class="input-group-btn">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                          <i class="material-icons">send</i>
                        </button>
                      </span>
                                </div>
                            </div>
                            <div class="form-group label-floating is-empty">
                                <label class="control-label" for="addon2">Floating label w/right addon</label>
                                <div class="input-group">
                                    <input type="text" id="addon2" class="form-control">
                                    <span class="input-group-btn">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                          <i class="material-icons">functions</i>
                        </button>
                      </span>
                                </div>
                            </div>
                            <div class="form-group is-empty is-fileinput">
                                <input type="file" id="inputFile4" multiple="">
                                <div class="input-group">
                                    <input type="text" readonly="" class="form-control" placeholder="Placeholder w/file chooser...">
                                    <span class="input-group-btn input-group-sm">
                        <button type="button" class="btn btn-fab btn-fab-mini">
                          <i class="material-icons">attach_file</i>
                        </button>
                      </span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- ms-paper-content -->
                </div>
                <!-- col-md-9 -->
            </div>
            <!-- row -->
        </div>
        <!-- ms-paper -->
    </div>


    <div class="form-group label-floating is-empty">
        <label class="control-label" for="focusedInput1">Write something to make the label float</label>
        <input class="form-control" id="focusedInput1" type="text">
    </div>
@endsection