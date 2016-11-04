<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer,
	Doctrine\ORM\Query\QueryException;

/**
 * @author Andrew Mackrodt <andrew@ajmm.org>
 */
class IfNull extends FunctionNode
{
    private $expr1;
    private $expr2;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();

        if($lexer->glimpse()['type'] == Lexer::T_CLOSE_PARENTHESIS) {
            $this->expr1 = $parser->ArithmeticExpression();
        } else {
            $this->expr1 = $parser->ConditionalExpression();
        }

        $parser->match(Lexer::T_COMMA);
        $this->expr2 = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'IFNULL('
            .$sqlWalker->walkArithmeticPrimary($this->expr1). ', '
            .$sqlWalker->walkArithmeticPrimary($this->expr2).')';
    }
}
