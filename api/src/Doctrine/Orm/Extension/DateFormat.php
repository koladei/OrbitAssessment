<?php

namespace App\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\TokenType;

/**
 * DateFormat ::= "DATE_FORMAT" "(" DateValue "," StringFormat ")"
 */
class DateFormat extends FunctionNode
{
  public $dateValue = null;
  public $formatExpression = null;

  public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker): string
  {
    return 'to_char(' .
      $this->dateValue->dispatch($sqlWalker) . ', ' .
      $this->formatExpression->dispatch($sqlWalker) .
      ')';
  }

  public function parse(\Doctrine\ORM\Query\Parser $parser): void
  {
    $parser->match(TokenType::T_IDENTIFIER);
    $parser->match(TokenType::T_OPEN_PARENTHESIS);
    $this->dateValue = $parser->ArithmeticPrimary();
    $parser->match(TokenType::T_COMMA);
    $this->formatExpression = $parser->ArithmeticPrimary();
    $parser->match(TokenType::T_CLOSE_PARENTHESIS);
  }
}
