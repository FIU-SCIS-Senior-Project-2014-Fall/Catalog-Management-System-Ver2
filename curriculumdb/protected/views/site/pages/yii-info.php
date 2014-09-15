<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>University Catalog System</title>
    </head>
    <body>
    <div class="documentation">
        <h1>University Catalog Management</h1>
        <p>
            This application is used to keep track of catalog changes at a
            university. 
        </p>
        <div class="border">
        <h2>Index File</h2>
        <h3>index.php in the root of the Yii application</h3>
        <p>
            The starting point for the Yii application is index.php in the root
            of the project. All processing is done through index.php. It is 
            possible to configure the server that hosts the application to hide
            the index.php.
        </p>
        <p>
           In index.php, set the location of the Yii framework and the location
           of the main configuration file, then create a web application and run
           it. Set any debugging parameters, too.
        </p>
        </div>
        <div class="border">
        <h2>Protected Folder</h2>
        <p>
            The protected folder contains all the controller, models and views.
            Controllers are all similar. Models are all similar. Views contain
            PHP and HTML. Views can represent the content of the page or can
            be the content of just a row of data.
        </p>
        <h3>main configuration file</h3>
        <p>The default name and location of the config file is 
            protected/config/main.php. Most of the statements in the config
            file are generated automatically.
        </p>
        <p>All properties and methods can be accessed in the application with
            Yii::app()->fieldName;
        <dl>
            <dt>basePath</dt>
            <dd>
                The basePath is the location of the protected folder in the 
                file system. This is not so useful, but some modules need it.
                Use <code>Yii::app()->request->baseUrl</code> for the
                URL to the directory containing the index page. This is useful
                for relative references, like an image location or a style 
                sheet location.             
            </dd>
            <dt>modules</dt>
            <dd>
                Additional PHP modules. Usually, these are written by someone
                else and included in the current application.
                <ul>
                    <li>gii - Allows auto creation of models and views.</li>
                    <li>user - Allows for Access Control Lists to be loaded
                        from a database table. This module can be used at
                    runtime to determine if the current user has admin rights:
                    <code>Yii::app()->getModule('user')->isAdmin()</code></li>
                    <li>
                        rights - Display rights.
                    </li>
                    <li>
                        catalog - helper module created as base class for 
                        controllers.
                    </li>
                    <li>
                        xmlGenerator - XML generator.
                    </li>
                </ul>
            </dd>
            <dt>components</dt>
            <dd>
                Additional features. See the 
                <a href="http://www.yiiframework.com/doc/api/1.1/CWebApplication">
                    Yii doc</a>. When accessing the components from the application,
                    the component will return the corresponding object. The component
                    is accessed using an accessor for the application. For instance,
                    to access the user component, call Yii::app()->getUser().
                    <ul>
                        <li>
                            db - set the parameters for accessing the database.
                        </li>
                        <li>
                            urlManager - define how to translate URLs into 
                            controller and action calls. Parse a URL and call
                            the corresponding controller/view/id. <a href="http://www.yiiframework.com/doc/guide/1.1/en/topics.url">
                                Yii doc on urlManager</a>
                        </li>
                    </ul>

            </dd>
            <dt>params</dt>
            <dd>
                Additional, user-defined parameters that can be accessed from
                the applciation with Yii::app()->params['paramName'].
            </dd>
            <dt>theme</dt>
            <dd>
                This looks like an unimplemented feature. The theme file from
                www is not being used.
            </dd>
        </dl>
        <h3>.htaccess</h3>
        <p>.htaccess is a config file for the Apache server. The contents of 
            this file prevent access to all the files in the protected folder
            from user access. The application can access these files, but a 
            user cannot browse through the folder from the web.
        <h3>controllers</h3>
        <p>
            Controllers are the brains of the application. Controllers are
            called base on the URL of a request.
        <ul>
            <li>filters - prevent/allow access to actions.</li>
            <li>accessRules - access control lists, based on user names. Wild 
                cards: * means quest, @ means authorized user.</li>
            <li>actions array - these actions are simple enough that they do
                not need a method. Yii doc for viewing 
                <a href="http://www.yiiframework.com/wiki/22/how-to-display-static-pages-in-yii/">
                    static pages</a>. 
            <li>actionXxxx methods - method names follow controller in a URL: controller/action.
                Remove the word action and change the next letter to lower case.
                <br>
                render - loads a complete view page
                <br>
                renderPartial - includes a partial view in another view.
            </li>
            
        </ul>
        </p>
        <h3>
            models
        </h3> 
        <p>
            Models are <a href="http://www.yiiframework.com/doc/api/1.1/CActiveRecord">
                CActiveRecord</a> objects. Data entered into a form is sent to
                a database record. Each table in the database has a model class.
                The Gii tool can generate model classes from a database table.
        </p>
        <p>
            Each CActiveRecord class has standard methods and properties.
        </p>
        <ul>
            <li>static model - returns the static object for this table, refer
                to this posting <a href="http://www.yiiframework.com/forum/index.php/topic/14456-class-level-methods-vs-static-methods/">
                    Class Level Methods versus Static Methods
                </a>. The active record classes only contain methods, no 
                instance variables.
                
                
            </li>
            <li>
                tableName
            </li>
            <li>
                rules - these are the validation rules for adding a row to the
                database. It is generated from the table using Gii.
            </li>
            <li>
                relations - Create indexes in mysql for tables that are related.
                The most complicated relation is many-to-many.
                Information on <a href="http://unknownyesterday.blogspot.com/2014/03/many-tomany-database-relation-in-yii.html">
                    many-to-many databases</a> relations.
            </li>
            <li>
                attributeLabels - Change the column name that appears in a view.
            </li>
            <li>
                search - Define how to find a row in the database.
            </li>
        </ul>
        </p>
        <h4>
            forms
        </h4>
        <p>
            These classes extend from 
            <a href="http://www.yiiframework.com/doc/api/1.1/CFormModel">
                CFormModel</a>. They can hold data that was entered in a form
                on the web, but the data is not stored in a database, it is
                only stored in memory. 
        </p>
        <h3>modules</h3>
        <p>Additional mini-apps, including controllers, views, models, etc. 
            Modules are like Java packages, they are self contained. Usually,
            they are added to the application from other developers, but 
            unique modules created for this application can also be added, like
            the catalog module.
            
        <h3>views</h3>
        <p>
            Each controller has a set of views. Some views are meant to be included
            in other views, for example when displaying records from a table.
            Each view has HTML and can access application parameters, such as 
            the model. Views that accept input use active forms, since the data
            entered will be added to the table.
        </p>
        <h4>layouts</h4>
        <p>The layouts are the base views that other views are built from. It
            allows each page to have the same look-and-feel. Place as much
            common content in the layout as possible. Other views will be 
            included in the final HTML page.
        </p>
        <p>
            All the controllers are extended from CController. CController has
            a layout property that controls how the views for the controller
            will appear. This application has one and two column layouts, as 
            well as a main layout that is used by the other two.
        </p>
        </div>
    </div>
    </body>
</html>
