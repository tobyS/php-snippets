<?php

namespace PHPaster;

/**
 * PHPaster UI.
 * 
 * @package PHPaster
 * @version 
 * @copyright Copyright (C) 2010 Tobias Schlitt. All rights reserved.
 * @author Tobias Schlitt <toby@php.net> 
 * @license New BSD License
 */
class Ui
{
    /**
     * Input handler.
     * 
     * @var ezcConsoleInput
     */
    protected $input;

    /**
     * Output handler.
     * 
     * @var ezcConsoleOutput
     */
    protected $output;

    /**
     * Creates a new PHPaster UI.
     */
    public function __construct()
    {
        $this->input = new \ezcConsoleInput();
        $this->output = new \ezcConsoleOutput();

        $this->registerParams();
    }

    /**
     * Processes the paste.
     * 
     * @return void
     */
    public function process()
    {
        try
        {
            $this->input->process();
        }
        catch ( Exception $e )
        {
            $this->printError( $e->getMessage() );
            return;
        }

        if ( $this->input->helpOptionSet() )
        {
            $this->printHelp( true );
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
            $this->printError( $e->getMessage() );
            return;
        }
        
        $this->output->outputLine( "Find your paste at {$url}" );
    }

    /**
     * Prints the program help text.
     *
     * If $long is true, extensive help will be printed.
     * 
     * @param bool $long 
     * @return void
     */
    protected function printHelp( $long = false )
    {
        $this->output->outputLine(
            $this->input->getHelpText(
                'PHPaster. Simple CLI pastebin client. Reads either from STDIN or given file name.',
                80,
                $long
            )
        );
    }

    /**
     * Prints the given $msg as an error and short help.
     * 
     * @param string $msg 
     * @return void
     */
    protected function printError( $msg )
    {
        $this->output->outputLine( 'ERROR: ' . $msg );
        $this->output->outputLine();
        $this->printHelp();
    }

    /**
     * Reads paste from STDIN or given file name.
     * 
     * @return string The Paste
     */
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

    /**
     * Registers input options and arguments.
     * 
     * @return void
     */
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
