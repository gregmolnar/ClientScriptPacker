Extends ClientScript to minify and pack registered assets. It uses the PHP port of Douglas Crockford's jsmin by rgrove (https://github.com/rgrove/jsmin-php).

##Requirements

I tested this extension with Yii 1.1.7 < but it should work from 1.1 onwards.

##Usage

Copy the folder into the extensions folder of your app. Than in the configuration file add the following section under components:

    'clientScript' => array(
      'class' => 'ext.ClientScriptPacker.ClientScriptPacker',
    ),

If this is done you can register your scriptfiles like you did before with `Yii::app()->clientScript->registerScriptFile()` and it will create the packed and minified javascript files in the assets folder. Your original JS files will stay untouched. If you want to re-pack the files just delete the files from your assets folder. I extended the `registerScriptFile` and it accepts an array as well with multiple js files.

IMPORTANT! You need to pass the path relatively to your ``$_SERVER['DOCUMENT_ROOT']`` to the registerScriptFile method.

If you experience any problem please give me a shout. 
I removed the caching because it didn't work well with the assets. The minify option is off by default because it can really slow down things. I need to rework this extension just need to find to do it.