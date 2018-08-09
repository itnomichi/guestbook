<?php

class View
{
    private $layout_dir = "";

    public function __construct()
    {
        $this->layout_dir = dirname(__DIR__) . "/app/views/";
    }

    public function renderPartial($_view_file_, $_data_ = null)
    {
        if (is_array($_data_))
            extract($_data_, EXTR_PREFIX_SAME, 'data');
        else
            $data = $_data_;
        ob_start();
        ob_implicit_flush(false);
        require($this->layout_dir . $_view_file_);
        return ob_get_clean();
    }

    public function render($view, $data = array())
    {
        $content = $this->renderPartial($view, $data);
        $html = $this->renderPartial("layout.php", ['content' => $content]);
        echo $html;
    }
}