<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/27
 * Time: 0:09
 */
namespace monkey\repl;

use yii\helpers\Console;


const PROMPT = ">> ";

const MONKEY_FACE = <<<EOD
HERE dummy MONKEY FACE
EOD;

/**
 * @param $in
 * @param $out
 */
function Start($in /*io.Reader*/ , $out /*io.Writer*/) {
     // print(__FUNCTION__) ;
    for(;true;){
      Console::stdout(PROMPT);
      $line = Console::stdin() ;
    }

    /*
    scanner := bufio.NewScanner(in)
	env := object.NewEnvironment()

	for {
        fmt.Printf(PROMPT)
		scanned := scanner.Scan()
		if !scanned {
            return
		}

		line := scanner.Text()
		l := lexer.New(line)
		p := parser.New(l)

		program := p.ParseProgram()
		if len(p.Errors()) != 0 {
            printParserErrors(out, p.Errors())
			continue
		}

		evaluated := evaluator.Eval(program, env)

		if evaluated != nil {
            io.WriteString(out, evaluated.Inspect())
			io.WriteString(out, "\n")
		}
	}
    */
}

/**
 * @param $out
 * @param $errors
 */
function printParserErrors($out /*io.Writer*/, $errors  /*string[]*/) {
    /*
    io.WriteString(out, MONKEY_FACE)
	io.WriteString(out, "Woops! We ran into some monkye business here!\n")
	io.WriteString(out, "  parser errors:\n")

	for _, msg := range errors {
        io.WriteString(out, "\t"+msg+"\n")
	}
    */
}