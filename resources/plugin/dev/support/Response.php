<?php

namespace Plugin\Support;

class Response
{
    /**
     * Restricts view resource
     *
     * @return void
     */
    public function private()
	{
		if (! defined('ABSPATH')) {
			http_response_code(404);

			die;
		}
	}

    /**
     * Create a view from resource file
     *
     * @param  string $script
     * @param  mixed $data
     *
     * @return html
     */
    public function view($script = null, $data = null)
    {
        if ($script == null) {

            return '';
        }

        $script = str_replace('.php', '', $script);
        $script = (str_replace('.', '/', $script)).'.php';
        $script = dirname(__DIR__, 1) . '/view/'.$script;

        if (! file_exists($script)) {

            return '';

        } else {

            if ($data) {
                $data = ! is_object($data) ? $data : (array) $data;
                $data = ! is_array($data) ? null : extract($data);
            }

            ob_start();

            include $script;

            $html = ob_get_contents();

            ob_end_clean();

            return $html;
        }
    }

}