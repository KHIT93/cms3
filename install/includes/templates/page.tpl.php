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
                            <div class="step-content">
                                <div class="step-pane active" data-step="1">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Welcome</h3>
                                            <p>Thank your for choosing our application for your website.<br/>Please choose your language below to proceed</p>
                                            <form name="chooseLanguage" method="GET" action="">
                                                <div class="form-group col-sm-8">
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
                                <div class="step-pane" data-step="3">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Verify Requirements</h3>
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Webserver</td>
                                                        <td><?php print $_SERVER['SERVER_SOFTWARE']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PHP Version</td>
                                                        <td class="<?php print (version_compare(phpversion(), '5.4.0', '>=')) ? 'bg-success': 'bg-danger'; ?>"><?php print PHP_VERSION; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PHP memory limit</td>
                                                        <td class="<?php print (ini_get('memory_limit') >= '128M') ? 'bg-success': 'bg-danger'; ?>"><?php print ini_get('memory_limit'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PHP Database Extension</td>
                                                        <td><?php print (extension_loaded('mysql')) ? 'Enabled': 'Disabled'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Filesystem</td>
                                                        <td class="<?php print (is_writable('uploads')) ? 'bg-success': 'bg-danger'; ?>"><?php print (is_writable('uploads')) ? 'Usable filesystem is readable': 'Usable filesystem is not readable'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Configuration file</td>
                                                        <td class="<?php print (is_writable('core/config')) ? 'bg-success': 'bg-danger'; ?>"><?php print (is_writable('core/config')) ? 'Configuration file can be written': 'Configuration file cannot be written'; ?></td>
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
                                            <form name="dbCredentials" method="POST" action="">
                                                <div class="form-group col-sm-8">
                                                    <label for="host">Database Host:</label>
                                                    <input type="text" name="host" class="form-control" id="host" value="localhost">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="username">Database Username:</label>
                                                    <input type="text" name="username" class="form-control" id="username">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="password">Database Password:</label>
                                                    <input type="password" name="password" class="form-control" id="password">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="db">Database:</label>
                                                    <input type="text" name="db" class="form-control" id="db">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="port">Database Port:</label>
                                                    <input type="text" name="port" class="form-control" id="port" value="3306">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="5">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Configuring the database</h3>
                                            <!-- Execute database configuration using AJAX -->
                                            <div class="progress progress-striped active">
                                                <div class="progress-bar progress-bar-info" style="width: 100%"></div>
                                            </div>
                                            <p>Installing <i>Database</i>...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="6">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Configure your site</h3>
                                            <form name="siteInformation" method="GET" action="">
                                                <div class="form-group col-sm-8">
                                                    <label for="name">Site name:</label>
                                                    <input type="text" name="name" class="form-control" id="name" value="<?php print $_SERVER['HTTP_HOST']; ?>">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="slogan">Site slogan:</label>
                                                    <input type="text" name="slogan" class="form-control" id="slogan">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="adminUser">Administrator username:</label>
                                                    <input type="text" name="adminUser" class="form-control" id="adminUser" value="admin">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="adminName">Administrator name:</label>
                                                    <input type="text" name="adminName" class="form-control" id="adminName" value="Administrator">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="adminEmail">Administrator email:</label>
                                                    <input type="text" name="adminEmail" class="form-control" id="adminEmail" placeholder="example@example.com">
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <label for="adminPassword">Administrator password:</label>
                                                    <input type="password" name="adminPassword" class="form-control" id="adminPassword">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane bg-info" data-step="7">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <h3 class="hthin">Installing</h3>
                                            <!-- Execute site configuration using AJAX. After each function completes change the progressbar length -->
                                            <div class="progress progress-striped active">
                                                <div class="progress-bar progress-bar-info" style="width: 100%"></div>
                                            </div>
                                            <p>Installing <i>%COMPONENT%</i>...</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-pane" data-step="8">
                                    <div class="form-group no-padding">
                                        <div class="col-sm-12">
                                            <div class="text-center">
                                                <div class="i-circle success"><i class="fa fa-check"></i></div>
                                                <h3 class="hthin">Congratulations!</h3>
                                                <p>Your new site is now configured and ready for use.</p>
                                                <p>If you need help to customize your site, you can check the <a href="/admin/help/getting-started">Help</a> section</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <button type="button" class="btn btn-rad btn-prev btn-default" disabled="disabled"> <span class="glyphicon glyphicon-arrow-left"></span>Prev</button>
                                <button type="button" class="btn btn-rad btn-next btn-primary" data-last="Finish">Next<span class="glyphicon glyphicon-arrow-right"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>