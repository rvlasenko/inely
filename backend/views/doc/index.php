<?php

/* @var $this yii\web\View */

\backend\assets\DocAsset::register($this);
$this->title = 'Справочный центр Inely';

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center"><img alt="" src="images/tick.svg"> Справочный центр Inely</h3>
            <h4 class="text-center">текущая версия: <span class="label label-primary">1.0</span></h4>
            <hr>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-3">
            <div class="affix" id="docNav" data-spy="affix" data-offset-top="150" data-offset-bottom="0">
                <ul class="nav nav-list nav-list-vivid">
                    <li class="nav-header">
                        <img alt="" src="images/tick.svg" style="width: 18px;bottom: 2px;position: relative;" />
                        <b>Содержание</b>
                    </li>
                    <li class="active">
                        <a href="#intro">Краткий тур</a>
                    </li>
                    <li>
                        <a href="#upgrading">Upgrading</a>
                    </li>
                    <li>
                        <a href="#requirements">Requirements</a>
                    </li>
                    <li>
                        <a href="#structure">Structure</a>
                    </li>
                    <li>
                        <a href="#codeigniter">CodeIgniter</a>
                    </li>
                </ul>
            </div>
            <!-- /#docNav -->
        </div>
        <!-- /.col-md-3 -->

        <div class="col-md-9">

            <div id="intro">

                <h4>Краткий тур</h4>

                <p>
                    <img alt="" src="images/tick.svg" style="width: 18px;"> Databased Personal is a self-hosted database application, allowing access to MySQL databases for non-technical people and technical people alike. With Databased Personal we are trying to make working with MySQL databases easier and available for everyone.
                </p>

                <p>
                    Databased Personal is not (yet) a replacement for phpMyAdmin or other MySQL administration tools as it offers only limited functionality mostly required by "regular" users. By "regular" users we mean sales staff, customer service reps, accountants etc.
                </p>

                <p>
                    Databased Personal is built using CodeIgniter 2.1.4 and Flat UI Pro.
                </p>

            </div>
            <!-- /#intro -->

            <br>

            <div id="upgrading">

                <h4>Upgrading</h4>

                <p>
                    Below you'll find information on how to upgrade.
                </p>

                <b>v1.0.1 to v1.0.2</b>

                <ul>
                    <li>
                        Update (overwrite) the following folders and files:<br>
                        - /application/views/table/table.php<br>
                    </li>
                </ul>

                <b>v1.0.2 to v1.0.3</b>

                <ul>
                    <li>
                        Update (overwrite) the following folders and files:<br>
                        - /application/models/tablemodel.php<br>
                    </li>
                </ul>

                <b>v1.0.3 to v1.0.4</b>

                <ul>
                    <li>
                        Update (overwrite) the following folders and files:<br>
                        - /application/views/account.php<br>
                    </li>
                </ul>

                <b>v1.0.4 to v1.0.5</b>

                <ul>
                    <li>
                        Update (overwrite) the following folders and files:<br>
                        - /application/views/table/<br>
                        - /application/models/
                        - /js/dbapp
                    </li>
                </ul>

            </div>
            <!-- /#upgrading -->

            <br>

            <h3>Before Installing</h3>

            <div id="requirements">

                <h4>Requirements</h4>

                <p>
                    To be able to install Databased Personal, you must have the following:
                </p>

                <ul>
                    <li>PHP 5.1.6 (older versions might work)</li>
                    <li>Apache webserver</li>
                    <li>MySQL with support for InnoDB tables and foreign keys</li>
                    <li>phpMyAdmin access to setup the initial database</li>
                    <li>An FTP tool to upload the files</li>
                </ul>

            </div>
            <!-- /#requirement -->

            <div id="structure">

                <h3>Structure</h3>

                <p>
                    Like mentioned before, Databased Personal is built using CodeIgniter and Flat UI Pro. To learn more about CodeIgniter, please
                    <a href="http://ellislab.com/codeigniter" target="_blank">visit the CodeIgniter website</a> or read the online documentation
                    <a href="http://ellislab.com/codeigniter/user-guide/" target="_blank">here</a>. To learn more about Flat UI Pro, please have a look
                    <a href="http://designmodo.com/flat/" target="_blank">here</a>.
                </p>

                <p>
                    In addition to the default CodeIgniter files, Databased Personal uses the following custom files:
                </p>

                <b>Controllers (/application/controllers/):</b><br>

                <ul>
                    <li>account.php</li>
                    <li>admin.php</li>
                    <li>columnnotes.php</li>
                    <li>columns.php</li>
                    <li>dashboard.php</li>
                    <li>db.php</li>
                    <li>recordnotes.php</li>
                    <li>revisions.php</li>
                    <li>roles.php</li>
                    <li>table_datasource.php</li>
                    <li>tablenotes.php</li>
                    <li>users.php</li>
                </ul>

                <b>Models (/application/models/):</b><br>

                <ul>
                    <li>columnnote_model.php</li>
                    <li>db_model.php</li>
                    <li>issue_model.php</li>
                    <li>recordnote_model.php</li>
                    <li>relation_model.php</li>
                    <li>revision_model.php</li>
                    <li>role_model.php</li>
                    <li>table_model.php</li>
                    <li>tablenote_model.php</li>
                    <li>user_model.php</li>
                </ul>

                <b>Views (/application/views/)</b><br>

                <p>
                    All files and folders are custom, except for the folder "/application/views/auth".
                </p>

                <b>Flat UI Pro files</b><br>

                <p>The following folders are part of the Flat UI Pro kit:</p>

                <ul>
                    <li>/bootstrap (contains basic bootstrap items)</li>
                    <li>/css (contains custom css)</li>
                    <li>/custom (contains less+css)</li>
                    <li>/fonts (contains the fonts used in Databased Personal)</li>
                    <li>/images (contains images used in Databased Personal)</li>
                    <li>/js (contains the Flat UI Pro javascript files)</li>
                    <li>/less (contains the original Flat UI Pro less files)</li>
                </ul>

                <b>Additional files/folders</b><br>

                <ul>
                    <li>/assets (contains some additional jQuery plugins + support files)</li>
                    <li>/swf (contains files used by the jQuery DataTables plugin)</li>
                </ul>

            </div>
            <!-- /#structure -->

            <div id="codeigniter">

                <h4>CodeIgniter</h4>

                <p>
                    Before continuing with the installation of Databased Personal, please make sure your hosting is capable of hosting CodeIgniter 2.1.4. In 99% of the cases, this won't be a be a problem :)
                </p>

            </div>
            <!-- /#codeigniter -->

            <br>

        </div>
        <!-- /.col-md-9 -->

    </div>

</div><!-- /.container -->