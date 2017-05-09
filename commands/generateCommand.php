<?php

namespace Dalnix\Commands;

use Dalnix\Base\baseCommand;
use League\Csv\Reader;
use Philo\Blade\Blade;
use Knp\Snappy\Pdf;

class generateCommand extends baseCommand {

	protected $bladeViewFolder = __DIR__ . '/../views/';
	protected $bladeCacheFolder = '/tmp';

	public function main( $args = null ) {
		//@todo fix this
		$args = $args[0];

		if ( ! $args || count( $args ) < 2 ) {
			return $this->help()[0];
		}

		$this->importFile = $args[0];
		$this->outputFile = $args[1];

		if ( file_exists( $this->importFile ) ) {
			if ( ! ini_get( "auto_detect_line_endings" ) ) {
				ini_set( "auto_detect_line_endings", '1' );
			}
			$this->csv   = Reader::createFromPath( $this->importFile );
			$this->blade = new Blade( $this->bladeViewFolder, $this->bladeCacheFolder );

			$pages       = [];
			$question_no = 1;
			$pages[] = $this->blade->view()->make('header')->with(['styling' => file_get_contents(__DIR__.'/../resources/question.css')])->render();
			$questions = $this->csv->fetchAll();
			foreach ( $questions as $question ) {
				if ( $question[0] == 'Question' ) {
					//This is the headers. We don't generate those as questions
					continue;
				}

				$pages[] = $this->blade->view()
				                       ->make( 'question' )
				                       ->with( [
					                       'question' => $question,
					                       'question_no' => $question_no++,

				                       ] )->render();

			}

			array_shift($questions);
			$pages[] = $this->blade->view()->make('facit')->with(['questions' =>$questions])->render();
			$pages[] = $this->blade->view()->make('footer')->render();
			$wkhtmlPath = null;
			if(env('WKTMLPATH',null)){
				$wkhtmlPath = env('WKHTMLPATH');
			}
			else{
				if(!empty( $this->shell_exec(sprintf('which %s','wkhtmltopdf')))){
					$wkhtmlPath = 'wkhtmltopdf';
				}
			}
			if(!$wkhtmlPath){
				return "wkhtmltopdf binary not found in path. Try specifying with WKHTMLPATH= env";
			}

			$snappy = new Pdf($wkhtmlPath);
			$snappy->setOption('page-size','a5');
			$snappy->setOption('orientation','portrait');

			$snappy->generateFromHtml(implode($pages), $this->outputFile,[],true);

			return "Generated ".$this->outputFile;

		}

	}

	public function help() {
		return [
			'generate: import.csv output.pdf',

		];
	}


}