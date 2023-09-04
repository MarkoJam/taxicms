<?
class XMLConfig {
    var $_XMLArray;
    var $_getCounter;

    function __construct() {
        
    }
    
    function Parse($XML) {
        if (function_exists("domxml_open_file")) {
            $openFile = "domxml_open_file";
        } else if (function_exists("xmldocfile")) {
            $openFile = "xmldocfile";
        } else {
            die("XMLConfig: DOM XML not found.");
        }
        
		if(file_exists($XML))
		{
			$tree = $openFile($XML);
			$root = $tree->root();
        
			$this->convertXMLToArray($root, $this->_xmlArray);
		}
    }
    
    function setDocument($root) {
        $this->_documentRoot = trim($root);
    }
    
    function get($path) {
        $this->_getCounter++;
        
        $path = trim($path);
        if (substr($path, 0, 1) == "/") {
            $path = substr($path, 1);
        }
        $path = explode("/", $path);
        $i = 0;
        $getPath="";
        while ($i < count($path)) {
            $getPath .= "['" . $path[$i] . "']";
            $i++;
        }
        eval("\$resultVar = & \$this->_xmlArray$getPath;"); 
        return $resultVar;
    }    
   
    function getData($path) {
        return $this->get($path);
    }
    function convertXMLToArray($branch, &$array) {
        $branch = $branch->first_child();
        while ($branch) {
            if ($branch->type == XML_ELEMENT_NODE) {
                if ($branch->has_child_nodes()) {
                    $next = $branch->first_child();
                    $content = $next->get_content();
                    if (!$next->is_blank_node()) {
                        if ($branch->node_name() == "value") {
                        	if(count($branch->attributes())!=0)
                            	$array[$branch->node_name()][$this->getAttribute("name",$branch->attributes())] = $next->get_content();
                            else 
                            	$array[$branch->node_name()][] = $next->get_content();
                        } else {
                            $array[$branch->node_name()] = $next->get_content();
                        }
                    }
                }
                $this->convertXMLToArray($branch, $array[$branch->node_name()]);
            }
            $branch = $branch->next_sibling();
        }
    }
	function getAttribute($name, $att)
	{
		foreach($att as $i)
	   	{
	       if($i->name()==$name)
	           return $i->value();       
	   }
	}
    
}
?>