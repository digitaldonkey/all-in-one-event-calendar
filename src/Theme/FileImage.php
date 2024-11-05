<?php

namespace Osec\Theme;

/**
 * Handle finding and parsing an image file.
 *
 * @since      2.0
 * @replaces Ai1ec_File_Image
 * @author     Time.ly Network Inc.
 */
class FileImage extends FileAbstract
{

    /**
     * @var string The url of the image file.
     */
    protected $_url;

    /**
     * Get the URL to the image file.
     *
     * @return string
     */
    public function get_url()
    {
        return $this->_url;
    }

    public function process_file()
    {
        $files_to_check = [];
        foreach (array_keys($this->_paths) as $path) {
            $files_to_check[ $path ] =
                $path.'img'.DIRECTORY_SEPARATOR.$this->_name;
        }
        foreach ($files_to_check as $path => $file) {
            if (file_exists($file)) {
                // Construct URL based on base URL available in $this->_paths array.
                $this->_url = $this->_paths[ $path ].'/img/'.$this->_name;
                $this->_content = $file;

                return true;
            }
        }

        return false;
    }
}