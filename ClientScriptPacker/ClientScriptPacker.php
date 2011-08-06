<?php
class ClientScriptPacker extends CClientScript
{
    public $packScriptFiles = true;
    public $compressScriptFiles = true;
    public $names = array(
		self::POS_HEAD => 'head.js',
		self::POS_BEGIN => 'begin.js',
		self::POS_END => 'end.js',
		
			  );
    public function renderHead(&$output)
    {
	    if ($this->packScriptFiles && $this->enableJavaScript)
		    $this->packScriptFiles(self::POS_HEAD);

	    parent::renderHead($output);
    }
    
    public function renderBodyBegin(&$output)
    {
	if ($this->packScriptFiles && $this->enableJavaScript)
		    $this->packScriptFiles(self::POS_BEGIN);
	    parent::renderHead($output);
    }
    
    public function renderBodyEnd(&$output)
    {
	if ($this->packScriptFiles && $this->enableJavaScript)
		    $this->packScriptFiles(self::POS_END);
	    parent::renderHead($output);
    }
    
    public function packScriptFiles($position)
    {
	$data = '';
	if(!file_exists(Yii::app()->assetManager->basePath . DIRECTORY_SEPARATOR.$this->names[$position])){	
	    if(isset($this->scriptFiles[$position])){
		foreach($this->scriptFiles[$position] as $file){
		    $data .= file_get_contents($file);
		}
		if($this->compressScriptFiles){
		    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'jsmin.php';
		    $data = JSMin::minify($data);
		}
		file_put_contents(Yii::app()->assetManager->basePath . DIRECTORY_SEPARATOR.$this->names[$position],$data);
		$this->scriptFiles[$position] = array(Yii::app()->assetManager->baseUrl . DIRECTORY_SEPARATOR.$this->names[$position]);
	    }
	}else{
	    $this->scriptFiles[$position] = array(Yii::app()->assetManager->baseUrl . DIRECTORY_SEPARATOR.$this->names[$position]);
	}
    }
    
    public function registerScriptFile($url,$position=self::POS_HEAD)
    {
	$this->hasScripts=true;	
	if(is_array($url)){
	    foreach($url as $script){
		$this->scriptFiles[$position][$script]=$script;
	    }
	}else{
	    $this->scriptFiles[$position][$url]=$url;
	}	
	$params=func_get_args();
	$this->recordCachingAction('clientScript','registerScriptFile',$params);
	return $this;
    }    
}