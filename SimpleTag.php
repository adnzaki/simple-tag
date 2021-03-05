<?php

/**
 * SimpleTag is a HTML writer for those who really love PHP!
 * It can be written with simple and structured API  
 * 
 * @author      Adnan Zaki
 * @package     Library
 * @license     MIT
 * @copyright   Woles DevTeam (c) 2021
 */

class SimpleTag
{
    /**
     * @var string
     */
    private $rawTag;

    /**
     * @var string
     */
    private $openTag;

    /**
     * @var string
     */
    private $closeTag;

    /**
     * @var string
     */
    private $content;

    /**
     * The HTML Renderer
     * 
     * @return void
     */
    public function render()
    {
        $this->close();
        $html = $this->openTag . $this->content . $this->closeTag . "\n";

        echo $html;
    }

    /**
     * HTML Element generator
     * 
     * @param string|array $tag
     * @param array $attributes
     * 
     * @return SimpleTag
     */
    public function elem($tag, array $attributes = [])
    {
        $result = '';
        if(is_array($tag))
        {
            $rawTag = array_keys($tag);

            // loop the tags
            foreach($tag as $k => $v) 
            {
                $attr = $this->createAttribute($v);
                $result .= "<{$k}{$attr}>";
            }
        }
        else
        {
            $attr = $this->createAttribute($attributes);           
            $result = "<{$tag}{$attr}>";
            $rawTag = [$tag];
        }

        $this->openTag = $result;
        $this->rawTag = $rawTag;

        return $this;
    }    

    /**
     * Set content of outer HTML
     * 
     * @param string $inner
     * @param string $outer
     * @param array $style
     * 
     * @return SimpleTag
     */
    public function setContent(string $inner, string $outer = 'p', array $style = [])
    {            
        $result = '';
        if(strpos($outer, '>') === false)
        {
            $styleStr = $this->createStyle($outer, $style);
            $result = '<'.$outer. ' ' .$styleStr.'>'. $inner .'</'.$outer.'>';
        }
        else
        {
            $removeSpace = str_replace(' ', '', $outer);
            $elems = explode('>', $removeSpace);
            $outerOpen = '';
            $outerClose = '';
            $outerCloseWrapper = [];
            foreach($elems as $val)
            {
                $styleStr = $this->createStyle($val, $style);
                $outerOpen .= '<' . $val . $styleStr . '>';
                $outerCloseWrapper[] = '</' . $val . '>';
            }

            $outerClose = implode('', array_reverse($outerCloseWrapper));

            $result = $outerOpen . $inner . $outerClose . "\n";            
        }

        $this->content .= $result;

        return $this;
    }

    /**
     * Create closing tag of element </>
     * 
     * @return void
     */
    private function close()
    {
        $wrapper = [];

        foreach($this->rawTag as $val)
        {
            $wrapper[] = "</$val>";
        }

        $this->closeTag = implode('', array_reverse($wrapper));
    }    

    /**
     * Create element attributes
     * 
     * @param array $attributes
     * 
     * @return string
     */
    private function createAttribute($attributes)
    {
        $attr = '';
        if(count($attributes) > 0)
        {
            foreach($attributes as $key => $val)
            {
                // create attribute like class="center"
                $attr .= ' ' . $key . '="' . $val .'"';
            }
        }

        return $attr;
    }

    /**
     * Create inline style of element
     * 
     * @param string $outer
     * @param array $style
     * 
     * @return string
     */
    private function createStyle($outer, $style)    
    {
        $styleStr = '';
        if(isset($style[$outer]))
        {
            $styleStr = 'style="';
            $closeStyle = '';
            $i = 1;
            foreach($style[$outer] as $k => $v)
            {                            
                if($i === count($style[$outer]))
                {
                    $closeStyle = '"';
                }
                $styleStr .= ' ' . $k .': ' . $v . ';' . $closeStyle;
                $i++;
            }

            return $styleStr;
        }
    }    
}   