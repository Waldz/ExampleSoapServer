<?php
namespace ZendExtensions\View\Helper;

use Zend\View\Helper\InlineScript as ZendInlineScript;

/**
 * Has da fix, which don't create script if already has TAG <script></script>
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class InlineScript
    extends ZendInlineScript
{

    /**
     * {@inheritdoc}
     */
    public function itemToString($item, $indent, $escapeStart, $escapeEnd)
    {
        if(!empty($item->source) && preg_match('/^\s*<script/', $item->source)) {
            return $item->source;
        } else {
            return parent::itemToString($item, $indent, $escapeStart, $escapeEnd);
        }
    }

}
