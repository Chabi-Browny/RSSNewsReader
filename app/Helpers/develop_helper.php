<?php

/* 
 */

if(!function_exists("vdx"))
{
    /**
     * @desc - var_dump extra változat
     * @param mix $inData - kiirandó adat
     */
    function vdx($inData)
    {
        echo"<pre>";
        var_dump($inData);
        echo"</pre>";
    }
}

if(!function_exists("dd"))
{
    /**
     * @desc - die dump
     * @param mix $inData - kiirandó adat
     */
    function dd($inData)
    {
        echo"<pre>";
        var_dump($inData);
        echo"</pre>";
        die("ddd");
    }
}