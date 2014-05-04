<?php
namespace ZendExtensions\View\Helper;

use Zend\View\Helper\HeadScript as ZendHeadScript;

/**
 * Has da fix, which don't create script if already has TAG <script></script>
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class HeadScript
    extends ZendHeadScript
{

    /**
     * {@inheritdoc}
     */
    public function itemToString($item, $indent, $escapeStart, $escapeEnd)
    {
        if (!empty($item->attributes['src'])) {
            $file = $item->attributes['src'];
            $fullFilePath = getcwd() . "/public/" . ltrim($file, '/ ');

            if (file_exists($fullFilePath)) {
                $item->attributes['src'] = $file . '?' . filemtime($fullFilePath);
            }
        }

        if(!empty($item->source) && preg_match('/^\s*<script/', $item->source)) {
            return $item->source;
        } else {
            return parent::itemToString($item, $indent, $escapeStart, $escapeEnd);
        }
    }

}