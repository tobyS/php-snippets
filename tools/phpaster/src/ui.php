<?php

namespace PHPaster;

class Ui
{
    protected $input;

    protected $output;

    public function __construct()
    {
        $this->input = new \ezcConsoleInput();
        $this->output = new \ezcConsoleOutput();

        $this->registerParams();
    }

    public function process()
    {
        try
        {
            $this->input->process();
        }
        catch ( Exception $e )
        {
            $this->output->outputLine( $e->getMessage() );
            return;
        }

        $paste = new Paste( $this->readPaste() );
        $paste->title  = $this->input->getOption( 'title' )->value;
        $paste->author = $this->input->getOption( 'author' )->value;

        $paster = new Paster\Pastebin();

        $this->output->outputLine( 'Sending paste …' );

        try
        {
            $url = $paster->paste( $paste );
        }
        catch ( Exception $e )
        {
            $this->output->outputLine( $e->getMessage() );
            return;
        }
        
        $this->output->outputLine( "Find your paste at {$url}" );
    }

    protected function readPaste()
    {
        if ( ( $file = $this->input->argumentDefinition['file']->value ) )
        {
            $this->output->outputLine( "Reading paste from '{$file}'." );
            return file_get_contents( $file );
        }
        $this->output->outputLine( 'Reading paste from STDIN.' );
        return file_get_contents( 'php://STDIN' );
    }

    protected function registerParams()
    {
        $this->input->registerOption(
            new \ezcConsoleOption(
                't',
                'title',
                \ezcConsoleInput::TYPE_STRING,
                '',
                false,
                'Paste title',
                'A title for the paste.'
            )
        );

        $this->input->registerOption(
            new \ezcConsoleOption(
                'a',
                'author',
                \ezcConsoleInput::TYPE_STRING,
                '',
                false,
                'Paste author',
                'Author of the paste.'
            )
        );

        $this->input->registerOption(
            new \ezcConsoleOption(
                'h',
                'help',
                \ezcConsoleInput::TYPE_NONE,
                null,
                false,
                'Print help',
                'Print help.',
                array(),
                array(),
                true,
                false,
                true                // isHelpOption
            )
        );

        $arg = new \ezcConsoleArgument( 'file' );
        $arg->shorthelp = 'Input file';
        $arg->longhelp  = 'Input file. If not set, read from STDIN.';
        $arg->mandatory = false;

        $this->input->argumentDefinition = new \ezcConsoleArguments();
        $this->input->argumentDefinition[0] = $arg;
    }
}

?>
