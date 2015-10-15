<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

\backend\assets\HelpAsset::register($this);
$main = "$('ul.panel-tabs li:nth-child(4)').addClass('active')";
$this->registerJs($main, $this::POS_END);

?>

<div>

    <div class="docs-container" id="docs">

        <div class="row table-layout">

            <!-- Documentation Nav -->
            <div class="col-xs-3 left-col">

                <span id="left-col-toggle" class="fa fa-navicon"></span>

                <!-- Navspy wrapper -->
                <div id="nav-spy" class="posr">

                    <!-- list group menu accordion -->
                    <ul class="list-group list-group-accordion">
                        <li class="list-group-item list-group-header br-n">Путеводитель по Inely</li>
                        <li class="list-group-item">
                            <a href="#introduction" data-toggle="tab"><?= Yii::t('backend', 'General') ?></a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab"><?= Yii::t('backend', 'Dates and times') ?></a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab"><?= Yii::t('backend', 'Keywords') ?></a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab"><?= Yii::t('backend', 'Keyboard shortcuts') ?></a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab"><?= Yii::t('backend', 'Notes') ?></a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab">Folder Structure</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#file-structure" data-toggle="tab">Folder Structure</a>
                        </li>
                    </ul>

                    <!-- list group menu accordion -->

                    <a href="#" class="scrollup" style="display: none;"><span class="fa fa-level-up"></span></a>
                </div>

            </div>

            <!-- Documentation Content -->
            <div class="col-xs-9 center-col va-t">

                <div id="docs-content" class="tab-content pn">

                    <!-- GENERAL -->
                    <div class="tab-pane fade active in" id="introduction" role="tabpanel">

                        <!-- intro -->
                        <section class="bs-docs-section">

                            <button data-toggle="modal" data-target="#timeline-modal" class="hidden btn btn-default btn-gradient btn-sm pull-right posr" type="button" style="top: -10px;">Requested Features</button>

                            <h1 class="page-header">Справочный центр</h1>

                            <p>The AdminDesigns UI Framework was designed to be one of the most balanced, well structured, and ideal solutions available to developers. Please feel free to contact as if you have any further questions regarding this theme. We're here to help!</p>

                            <h4>Don't forget to rate us <b class="text-warning">Five Stars!</b>
                            <span class="ml10">
                              <span class="fa fa-star text-warning mr5"></span>
                              <span class="fa fa-star text-warning mr5"></span>
                              <span class="fa fa-star text-warning mr5"></span>
                              <span class="fa fa-star text-warning mr5"></span>
                              <span class="fa fa-star text-warning mr5"></span>
                            </span>
                            </h4>

                            <p>If you like our theme and appreciate our hard work please rate us
                                <b>Five</b> Stars on Themeforest! Feel the need to rate us lower? Please contact us first and we will do absolutely everything we can to solve the problem. Happy customers are our number one priority!
                            </p>

                            <!-- basics -->

                            <h2> Mastering the Basics </h2>

                            <p>The AdminDesigns UI theme was developed using several libraries and platforms. It's vital that you understand a great deal about these technologies as it will allow you to fully understand the techniques, methodologies, and structures found in this theme. Fully understanding Bootstrap and the other platforms listed below is vital. </p>
                            <br>

                            <div class="row text-center mb50">
                                <div class="col-xs-4"><i class="fa fa-check fa-2x text-success  mb10"></i>
                                    <h5><b>JQuery API Documentation</b></h5>
                                    <a href="http://api.jquery.com/"> http://api.jquery.com/</a>
                                </div>
                                <div class="col-xs-4"><i class="fa fa-check fa-2x text-success mb10"></i>
                                    <h5><b>Bootstrap Documentation</b></h5>
                                    <a href="http://getbootstrap.com/css/"> http://getbootstrap.com/css/</a>
                                </div>
                                <div class="col-xs-4"><i class="fa fa-check fa-2x text-success  mb10"></i>
                                    <h5><b>LESS Documentation</b></h5>
                                    <a href="http://lesscss.org/"> http://lesscss.org/#</a>
                                </div>
                            </div>

                            <!-- color system -->

                            <h3>AdminDesigns Color System </h3>

                            <p>AdminDesigns has taken everything you love about bootstraps contextual system and extended it. Adding additional colors and extending its use to many new elements.</p>

                            <h4 class="mt25 mb15">The Cliff Notes:</h4>

                            <ul class="fs14 list-unstyled list-spacing-10 mb10 pl5">
                                <li>
                                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                                    Color system based on Bootstraps beloved <b>"contextual"</b> color system
                                </li>
                                <li>
                                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                                    <b> Three</b> new contextual classes have been added -
                                    <span class="label label-alert ph10 mh5">Alert</span>
                                    <span class="label label-system ph10 mr5">System</span>
                                    <span class="label label-dark ph10">Dark</span>
                                </li>
                                <li>
                                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                                    These contextual classes have been extended to nearly all elements, inputs, and widgets.
                                </li>
                                <li>
                                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                                    Each contextual has an additional <b> two shades </b> to select from
                                    <code> .light .dark </code>
                                </li>
                                <li>
                                    <i class="fa fa-exclamation-circle text-warning fa-lg pr10"></i>
                                    To reduce CSS bloat individual contextuals can be easily disabled
                                    <b>(see LESS section of Docs)</b>
                                </li>
                            </ul>
                        </section>

                    </div>

                    <!-- FILE STRUCTURE -->
                    <div class="tab-pane fade" id="file-structure" role="tabpanel">
                        <h3 id="" class="page-header">AdminDesigns - Folder Structure </h3>

                        <div class="bs-docs-section">

                            <h2 id="text-contextuals">Folder Explanation</h2>

                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - assets/</code><br>
                                <code> - email-templates/</code><br>
                                <code> - landing-page/</code><br>
                                <code> - vendor/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>assets/</code></td>
                                        <td>The Assets directory folder contains
                                            <b>Core</b> resources specifically created for the AdminDesigns theme. This includes the themes primary stylesheet/less, fonts, images, and custom plugins.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>email-templates/</code></td>
                                        <td>The email templates directory folder contains a series of premade email templates which do not require theme resources outside of its own folder. It also contains a series of PSDS to help customize the email templates to your needs. A demonstration can be seen
                                            <a href="http://admindesigns.com/framework/email_templates.html" target="_blank">here</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>landing-page/</code></td>
                                        <td>The Landing page directory folder contains all of the resources required to generate the home-page seen
                                            <a href="http://admindesigns.com/framework/landing-page/landing1/index.html" target="_blank">here</a>. We plan to implement more landing pages in the future.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>vendor/</code></td>
                                        <td>The Vendor directory folder contains all of the third party resources which the AdminDesigns theme uses. This includes the jQuery/jQuery UI libraries and all plugins except those which are considered
                                            <b>"Core"</b>. You can read more about what files are not included and reside in the utility.js(Core) in the javascript section of the documentation.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h2 id="text-contextuals">Folder Details - <code>theme/assets/</code></h2>

                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/assets</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - admin-tools/</code><br>
                                <code> - fonts/</code><br>
                                <code> - img/</code><br>
                                <code> - js/</code><br>
                                <code> - skin/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>admin-tools/</code></td>
                                        <td>
                                            <p class="mb20">The Admin Tools folder contains custom made plugins too large to be included in the themes core. After all no one likes excessive bloat. Currently this folder only contains the "Admin Forms" plugin and its related styles. However, we have plans to add additional custom plugins in the future. All other currently implemented plugins (adminpanels, dock,etc) have been moved into the themes
                                                <b>Core</b>(utility.js) as their overall file size is very small.</p>

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Designated for themes "larger" custom plugins </li>
                                                <li> Admin Forms and associated Less files are kept here </li>
                                                <li> Plugins here are not considered <b>"Core"</b> </li>
                                                <li> You must include links on your page to use these resources </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>fonts/</code></td>
                                        <td>The "fonts" folder contains a
                                            <b>COPY</b> of all fonts and font icon libraries used through out the theme. By default the theme includes
                                            <b> Glyphicons Halflings, and Font Awesome</b> libraries in
                                            <code>theme.css</code>. The only time you will utilize the fonts in this folder is if you wish to use one of the included(but not activated) font libraries. They have not been included by default to prevent massive css bloat. An overview of what font libraries can be viewed
                                            <a href="http://admindesigns.com/framework/ui_icons.html" target="_blank">here</a>

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Includes all font libraries included with theme </li>
                                                <li> Only Glyphicons Halfling and FontAwesome are included in master theme.css</li>
                                                <li> You must include links on your pages to use other font libraries</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>img/</code></td>
                                        <td>The "img" folder is pretty self explanatory. It contains an organized directory of avatars, sprites, and stock images that are used through out the theme. All images have been properly compressed, analyzed for bloat, and are required for theme demonstrative purposes. The images found inside of
                                            <code>plugins/</code> should not be removed.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> All images compressed and organized </li>
                                                <li> Images in <code>plugins/</code> should not be removed</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>js/</code></td>
                                        <td>The "js" folder contains all of the <b>demo</b> and
                                            <b>core</b> javascript files required for theme functionality. This includes demo javascript which you may not need. It's a good idea to read more about this folder in the javascript tutorial.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains both Demo and Core javascript files. </li>
                                                <li> More information can be found in documentations javascript tutorial</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>skin/</code></td>
                                        <td>The "skin" folder contains all of the Less files required to generate the themes primary stylesheet. The Less structure follows a "Parent/Child" inheritance pattern which allows for endless customization and modularity. To get the most out of the AdminDesigns theme it is
                                            <b>Highly</b> recommended that you learn more about the themes Less structure and ways to manipulate/optimize it. Learn more in the
                                            <a href="http://admindesigns.com/framework/documentation/views/tutorials/tutorial_less.html">tutorials</a> section of this documentation.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains Less files which generate entire theme. </li>
                                                <li> More information can be found in documentations Less tutorial</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                            <h2 id="text-contextuals">Folder Details - <code>theme/vendor/</code></h2>

                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/assets</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - bootstrap/</code><br>
                                <code> - jquery/</code><br>
                                <code> - plugins/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>bootstrap/</code></td>
                                        <td>The "bootstrap" folder is not used, and is for reference only. It contains all of the uncompressed javascript files which have been minified and merged into the themes core. The folder remains simply to preserve the original, and in use javascript files which can be found minified in
                                            <code> utility.js</code>

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Original Bootstrap reference javascript files </li>
                                                <li> Not used. Bootstrap.js has been minified and merged into themes Core</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>jquery/</code></td>
                                        <td>The "jquery" folder contains a local copy of the jQuery and jQuery UI libraries. Nearly every computer will have these files already cached making them virtually weightless. For that reason it is recommended that you serve these files via Googles CDN services and not via your own server. These libraries are required for proper theme functionality.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Includes the jQuery and jQuery UI libraries. </li>
                                                <li> It's recommended you serve these files via Google CDN
                                                    <a href="https://developers.google.com/speed/libraries/devguide">link</a></li>
                                                <li> Libraries are required for proper theme functionality </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>plugins/</code></td>
                                        <td>The "plugins" folder contains all 3rd party plugins used throughout the theme. While many of the plugins are required for demonstrative use, none of them are required for core theme functionality. Documentation and use examples can be found in the plugins section of the documentation.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains all "3rd party" plugins </li>
                                                <li> Files not required for core theme functionality</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    <!-- JS STRUCTURE -->
                    <div class="tab-pane fade" id="js-structure" role="tabpanel">
                        <h3 id="" class="page-header">AdminDesigns - Javascript Structure </h3>

                        <div class="bs-docs-section">

                            <h2 id="text-contextuals">Important Javascript Folders</h2>


                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - assets/utility</code><br>
                                <code> - vendor/plugins</code><br>
                                <code> - landing-page/</code><br>
                                <code> - vendor/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>assets/</code></td>
                                        <td>The Assets directory folder contains
                                            <b>Core</b> resources specifically created for the AdminDesigns theme. This includes the themes primary stylesheet/less, fonts, images, and custom plugins.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>email-templates/</code></td>
                                        <td>The email templates directory folder contains a series of premade email templates which do not require theme resources outside of its own folder. It also contains a series of PSDS to help customize the email templates to your needs. A demonstration can be seen
                                            <a href="http://admindesigns.com/framework/email_templates.html" target="_blank">here</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>landing-page/</code></td>
                                        <td>The Landing page directory folder contains all of the resources required to generate the home-page seen
                                            <a href="http://admindesigns.com/framework/landing-page/landing1/index.html" target="_blank">here</a>. We plan to implement more landing pages in the future.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>vendor/</code></td>
                                        <td>The Vendor directory folder contains all of the third party resources which the AdminDesigns theme uses. This includes the jQuery/jQuery UI libraries and all plugins except those which are considered
                                            <b>"Core"</b>. You can read more about what files are not included and reside in the utility.js(Core) in the javascript section of the documentation.
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h2 id="text-contextuals">Folder Details - <code>theme/assets/</code></h2>

                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/assets</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - admin-tools/</code><br>
                                <code> - fonts/</code><br>
                                <code> - img/</code><br>
                                <code> - js/</code><br>
                                <code> - skin/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>admin-tools/</code></td>
                                        <td>
                                            <p class="mb20">The Admin Tools folder contains custom made plugins too large to be included in the themes core. After all no one likes excessive bloat. Currently this folder only contains the "Admin Forms" plugin and its related styles. However, we have plans to add additional custom plugins in the future. All other currently implemented plugins (adminpanels, dock,etc) have been moved into the themes
                                                <b>Core</b>(utility.js) as their overall file size is very small.</p>

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Designated for themes "larger" custom plugins </li>
                                                <li> Admin Forms and associated Less files are kept here </li>
                                                <li> Plugins here are not considered <b>"Core"</b> </li>
                                                <li> You must include links on your page to use these resources </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>fonts/</code></td>
                                        <td>The "fonts" folder contains a
                                            <b>COPY</b> of all fonts and font icon libraries used through out the theme. By default the theme includes
                                            <b> Glyphicons Halflings, and Font Awesome</b> libraries in
                                            <code>theme.css</code>. The only time you will utilize the fonts in this folder is if you wish to use one of the included(but not activated) font libraries. They have not been included by default to prevent massive css bloat. An overview of what font libraries can be viewed
                                            <a href="http://admindesigns.com/framework/ui_icons.html" target="_blank">here</a>

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Includes all font libraries included with theme </li>
                                                <li> Only Glyphicons Halfling and FontAwesome are included in master theme.css</li>
                                                <li> You must include links on your pages to use other font libraries</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>img/</code></td>
                                        <td>The "img" folder is pretty self explanatory. It contains an organized directory of avatars, sprites, and stock images that are used through out the theme. All images have been properly compressed, analyzed for bloat, and are required for theme demonstrative purposes. The images found inside of
                                            <code>plugins/</code> should not be removed.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> All images compressed and organized </li>
                                                <li> Images in <code>plugins/</code> should not be removed</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>js/</code></td>
                                        <td>The "js" folder contains all of the <b>demo</b> and
                                            <b>core</b> javascript files required for theme functionality. This includes demo javascript which you may not need. It's a good idea to read more about this folder in the javascript tutorial.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains both Demo and Core javascript files. </li>
                                                <li> More information can be found in documentations javascript tutorial</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>skin/</code></td>
                                        <td>The "skin" folder contains all of the Less files required to generate the themes primary stylesheet. The Less structure follows a "Parent/Child" inheritance pattern which allows for endless customization and modularity. To get the most out of the AdminDesigns theme it is
                                            <b>Highly</b> recommended that you learn more about the themes Less structure and ways to manipulate/optimize it. Learn more in the
                                            <a href="http://admindesigns.com/framework/documentation/views/tutorials/tutorial_less.html">tutorials</a> section of this documentation.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains Less files which generate entire theme. </li>
                                                <li> More information can be found in documentations Less tutorial</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                            <h2 id="text-contextuals">Folder Details - <code>theme/vendor/</code></h2>

                            <div class="bs-example required-url">
                                <code>AdminDesigns/theme/assets</code>
                            </div>
                            <div class="bs-example required-files">
                                <code> - jquery/</code><br>
                                <code> - plugins/</code><br>
                            </div>

                            <div class="table-responsive mb40">
                                <table class="table table-bordered table-striped">
                                    <colgroup>
                                        <col class="col-xs-2">
                                        <col class="col-xs-10">
                                    </colgroup>
                                    <thead class="">
                                    <tr>
                                        <th>Directory Folder</th>
                                        <th>File Overview</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><code>jquery/</code></td>
                                        <td>The "jquery" folder contains a local copy of the jQuery and jQuery UI libraries. Nearly every computer will have these files already cached making them virtually weightless. For that reason it is recommended that you serve these files via Googles CDN services and not via your own server. These libraries are required for proper theme functionality.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Includes the jQuery and jQuery UI libraries. </li>
                                                <li> It's recommended you serve these files via Google CDN
                                                    <a href="https://developers.google.com/speed/libraries/devguide">link</a></li>
                                                <li> Libraries are required for proper theme functionality </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><code>plugins/</code></td>
                                        <td>The "plugins" folder contains all 3rd party plugins used throughout the theme. While many of the plugins are required for demonstrative use, none of them are required for core theme functionality. Documentation and use examples can be found in the plugins section of the documentation.

                                            <h5>Key Points</h5>
                                            <ul class="list">
                                                <li> Contains all "3rd party" plugins </li>
                                                <li> Files not required for core theme functionality</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- RETURN TO TOP BUTTON -->
                    <div class="top-wrapper clearfix">
                        <a href="#" class="return-top">Return to Top</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>