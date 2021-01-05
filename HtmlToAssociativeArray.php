<?php

Class HtmlToAssociativeArray {

   /**
   * Returns DomObject
   *
   * @return object
   *   Returns object.
   */

  public function getDOMDocument($html) {
   $dom = new \DOMDocument;
   libxml_use_internal_errors(true);
   $dom->loadHTML(\mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
   libxml_use_internal_errors(false);  
   return $dom;
  }

  /**
   * Returns inner html
   *
   * @return string
   *   Returns string.
   */
  public  function getInnerHTML($element) { 
    $innerHTML = ""; 
    $children  = $element->childNodes;
    foreach ($children as $child) { 
      $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    return $innerHTML; 
  }

  /**
   * Returns Allowed Tags
   *
   * @return array
   *   Returns array.
   */
public function getTagsType() {
    $html_tags = [];
    $html_tags['h1'] = "header_1";
    $html_tags['h2'] = "header_2";
    $html_tags['h3'] = "header_3";
    $html_tags['h4'] = "header_4";
    $html_tags['h5'] = "header_5";
    $html_tags['h6'] = "header_6";
    $html_tags['blockquote'] = "blockquote";
    $html_tags['p'] = "paragraph";
    $html_tags['text'] = "text"; 
    $html_tags['b'] = "bold";
    $html_tags['strong'] = "strong";
    $html_tags['i'] = "italic";
    $html_tags['span'] = "span"; 
    $html_tags['ul'] = "unordered_list";
    $html_tags['ol'] = "ordered_list";
    $html_tags['li'] = "list";
    $html_tags['table'] = "table";
    $html_tags['tr'] = "tr";
    $html_tags['td'] = "td";
    $html_tags['tbody'] = "tbody"; 
    $html_tags['th'] = "thead";
    $html_tags['thead'] = "thead"; 
    $html_tags['a'] = "anchor";
    $html_tags['br'] = "break";
    $html_tags['pre'] = "pre";
    $html_tags['em'] = "em";
    $html_tags['div'] = "div";
    $html_tags['span'] = "span";
    return $html_tags;
  }


  /**
   * Returns associative array 
   *
   * @return array
   *   Returns array.
   */
  public function htmlToJson($html) {
       if($html == "") return "";
      $dom = $this->getDOMDocument($html);
      $xpath = new \DOMXPath($dom);
      $nodes = $xpath->evaluate('//body/* | //body/text()');
      $noChild = ["br"];
      $tags = $this->getTagsType();
      if($nodes->length > 0) {
        foreach ($nodes as $key => $node) {
          if(isset($tags[$node->nodeName])) {
         $thisa_array= [ "type" => $tags[$node->nodeName]];
          foreach( $node->attributes as $attr )  $thisa_array[$attr->nodeName] = $attr->nodeValue;
         $children = $this->getInnerHTML($node);
         if($children != "" && !in_array($node->nodeName, $noChild)) {

          if($children != strip_tags($children)) {
             $thisa_array["children"] = $this->htmlToJson($children);
          }else {
            $thisa_array["text"] = $this->getInnerHTML($node);
          }
         }
          $array[] = $thisa_array;   
         }else {
          $array[] = ["type" => "text", "text" => $node->nodeValue];
         }
       }
      }  
       
      return $array;
  }

}


$util = new HtmlToAssociativeArray();
$html = "<ul class='list'>
            <li class='list-item'>one</li>
            <li>two</li>
            <li>three</li>
        </ul>";
$htmlArray = $util->htmlToJson($html);
echo json_encode($htmlArray);
