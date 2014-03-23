<?php
/**
 * PhpWord
 *
 * Copyright (c) 2014 PhpWord
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @copyright  Copyright (c) 2014 PhpWord
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.8.0
 */

namespace PhpOffice\PhpWord\Section;

use PhpOffice\PhpWord\Style\Paragraph;

class Footnote
{
    /**
     * Paragraph style
     *
     * @var \PhpOffice\PhpWord\Style\Paragraph
     */
    private $_styleParagraph;

    /**
     * Footnote Reference ID
     *
     * @var string
     */
    private $_refId;

    /**
     * Text collection
     *
     * @var array
     */
    private $_elementCollection;

    /**
     * Create a new Footnote Element
     */
    public function __construct($styleParagraph = null)
    {
        $this->_elementCollection = array();

        // Set paragraph style
        if (is_array($styleParagraph)) {
            $this->_styleParagraph = new Paragraph();

            foreach ($styleParagraph as $key => $value) {
                if (substr($key, 0, 1) != '_') {
                    $key = '_' . $key;
                }
                $this->_styleParagraph->setStyleValue($key, $value);
            }
        } else {
            $this->_styleParagraph = $styleParagraph;
        }
    }


    /**
     * Add a Text Element
     *
     * @var string $text
     * @var mixed $styleFont
     * @return \PhpOffice\PhpWord\Section\Text
     */
    public function addText($text = null, $styleFont = null)
    {
        $givenText                  = $text;
        $text                       = new Text($givenText, $styleFont);
        $this->_elementCollection[] = $text;
        return $text;
    }

    /**
     * Add a Link Element
     *
     * @param string $linkSrc
     * @param string $linkName
     * @param mixed $styleFont
     * @return \PhpOffice\PhpWord\Section\Link
     */
    public function addLink($linkSrc, $linkName = null, $styleFont = null)
    {

        $link = new Link($linkSrc, $linkName, $styleFont);
        $rID = \PhpOffice\PhpWord\Footnote::addFootnoteLinkElement($linkSrc);
        $link->setRelationId($rID);

        $this->_elementCollection[] = $link;
        return $link;
    }

    /**
     * Get Footnote content
     *
     * @return array
     */
    public function getElements()
    {
        return $this->_elementCollection;
    }

    /**
     * @return \PhpOffice\PhpWord\Style\Paragraph
     */
    public function getParagraphStyle()
    {
        return $this->_styleParagraph;
    }

    /**
     * Get Footnote Reference ID
     *
     * @return int
     */
    public function getReferenceId()
    {
        return $this->_refId;
    }

    /**
     * Set Footnote Reference ID
     *
     * @param int $refId
     */
    public function setReferenceId($refId)
    {
        $this->_refId = $refId;
    }
}
