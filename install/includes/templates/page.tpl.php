<body class="fuelux installer" style="opacity: 1;">
    <div id="cl-wrapper">
        <div class="container-fluid">
            <div class="cl-mcont">
                <div class="row wizard-row">
                    <div class="col-md-12">
                        <div data-initialize="wizard" class="wizard wizard-ux" id="myWizard">
                            <div class="navigation">
                                <ul class="steps">
                                    <li data-step="1" class="active"><span class="badge">1</span>Welcome<span class="chevron"></span></li>
                                    <li data-step="2"><span class="badge">2</span>License<span class="chevron"></span></li>
                                    <li data-step="3"><span class="badge">3</span>Requirements<span class="chevron"></span></li>
                                    <li data-step="4"><span class="badge">4</span>Database<span class="chevron"></span></li>
                                    <li data-step="5"><span class="badge">5</span>Configure Database<span class="chevron"></span></li>
                                    <li data-step="6"><span class="badge">6</span>Configure Site<span class="chevron"></span></li>
                                    <li data-step="7"><span class="badge">7</span>Install<span class="chevron"></span></li>
                                    <li data-step="8"><span class="badge">8</span>Finished<span class="chevron"></span></li>
                                </ul>
                            </div>
                            <div class="actions">
                                <button type="button" class="btn btn-rad btn-prev btn-default" disabled="disabled"> <span class="glyphicon glyphicon-arrow-left"></span>Prev</button>
                                <button type="button" class="btn btn-rad btn-next btn-primary" data-last="Finish">Next<span class="glyphicon glyphicon-arrow-right"></span></button>
                            </div>
                            <div class="step-content">
                                <div class="step-pane active" data-step="1">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Welcome</h3>
                                            <p>Thank your for choosing our application for your website.<br/>Please choose your language below to proceed</p>
                                            <form name="chooseLanguage" method="GET" action="">
                                                <div class="form-group col-md-6">
                                                    <select name="lang" class="select2">
                                                        <option value="en">English</option>
                                                        <option value="da">Danish</option>
                                                        <option value="de">German</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane" data-step="2">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">License</h3>
                                            <form name="acceptLicense" method="GET" action="">
                                                <p>Please read and accept the license terms below in order to proceed.</p>
                                                <h4>Application License</h4>
                                                <p>The core application and underlying code is licensed under GPLv2</p>
                                                <div class="checkbox">
                                                    <label class="checkbox-custom" data-initialize="checkbox">
                                                    <input type="checkbox" name="app_license" value="accepted" class="sr-only">
                                                    <span class="checkbox-label">I accept the application license</span>
                                                    </label>
                                                </div>
                                                <h4>Twitter Bootstrap License</h4>
                                                <p>The Twitter Bootstrap Design Framework and addon components used in this application is licensed under <a href="https://github.com/twbs/bootstrap/blob/master/LICENSE" target="_blank">MIT</a></p>
                                                <div class="checkbox">
                                                    <label class="checkbox-custom" data-initialize="checkbox">
                                                    <input type="checkbox" name="bootstrap_license" value="accepted" class="sr-only">
                                                    <span class="checkbox-label">I accept the Bootstrap license</span>
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="3">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Verify Requirements</h3>
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>PHP Version</td>
                                                        <td><?php print PHP_VERSION; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PHP memory limit</td>
                                                        <td>ini_get('memory_limit')</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Configuration file</td>
                                                        <td>Configuration file cannot be written</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="4">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Connect to the database</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="5">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Configuring the database</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="6">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Configure your site</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="7">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Installing</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="8">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Finished</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>