<?php
namespace ZendExtensions\View\Helper;

use stdClass;
use Zend\View\Helper\HeadLink as ZendHeadLink;

/**
 * Has da fix, which don't create script if already has TAG <script></script>
 *
 * @author Valdas Petrulis <petrulis.valdas@gmail.com>
 */
class HeadLink
    extends ZendHeadLink
{
    /**
     * {@inheritdoc}
     */
    public function itemToString(stdClass $item)
    {
        if (!empty($item->href)) {
            $file = $item->href;
            $fullFilePath = getcwd() . "/public/" . ltrim($file, '/ ');

            if (file_exists($fullFilePath)) {
                $item->href = $file . '?' . filemtime($fullFilePath);
            }
        }

        return parent::itemToString($item);
    }

}