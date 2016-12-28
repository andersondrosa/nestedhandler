<?php

namespace AndersonDRosa\NestedHandler;

class NestedHandler
{
    use \AndersonDRosa\Traits\Listener;

    public function __construct(array $config = null)
    {

    }

    public function render($content)
    {
        $p = "|\{([^{}]*)\}|U";

        $self = $this;

        for ($i = 0; $i < 10000; $i++) {

            $success = false;

            $content = preg_replace_callback($p, function ($m) use ($self, &$success) {

                $success = 1;

                $bag = new \stdClass;
                $bag->content = $m[1] == ' ' ? null : $m[1];

                $self->fire('each', [$bag]);

                return $bag->content;

            }, $content);

            if (!$success) {
                break;
            }
        }

        return $content;
    }

}
