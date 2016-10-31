<?php
/**
 * DokuWiki Plugin kitty (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_kitty extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 155;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\{\{kitty \d+ \d+\}\}',$mode,'plugin_kitty');
    }


    /**
     * Handle matches of the kitty syntax
     *
     * @param string          $match   The match of the syntax
     * @param int             $state   The state of the handler
     * @param int             $pos     The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        $match = trim(substr($match, 7, -2));
        list($width, $height) = explode(' ',  $match);

        $width = (int) $width;
        $height = (int) $height;


        return array($width, $height);
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml') return false;

        list($width, $height) = $data;

        if($this->getConf('bw')){
            $g = 'g/';
        } else {
            $g = '';
        }

        $renderer->doc .= '<img src="http://placekitten.com/'.$g.$width.'/'.$height.'" class="kitty" title="'.$this->getLang('kitty').'">';

        return true;
    }
}

// vim:ts=4:sw=4:et:
