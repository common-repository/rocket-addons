<?php

namespace RocketElementorForm\Vicextender;

if ( ! defined( 'ABSPATH' ) )  {
	exit;
}
class ROCKET_Extension_Extender {
	public function __construct() {
	}

	public function rocket_get_operator( $operator ) {
		if ( 'empty' === $operator ) {
			$js_operator = '== ""';
		} elseif ( 'greater' === $operator ) {
			$js_operator = '>';
		} elseif ( 'less' === $operator ) {
			$js_operator = '<';
		} elseif ( 'greaterequal' === $operator ) {
			$js_operator = '>=';
		} elseif ( 'lessequal' === $operator ) {
			$js_operator ='<=';
		} elseif ( 'equal' === $operator ) {
			$js_operator = '==';
		} elseif ( 'not_empty' === $operator ) {
			$js_operator = '!= ""';
		} elseif ( 'not_equal' === $operator ) {
			$js_operator = '!=';
		}
		return $js_operator;
	}

	public function rocket_conditional_checker( $field_target ) {
		$js_checker = 'jQuery("' . $field_target . '").length';
		return $js_checker;
	}

	public function rocket_conditional_visibility( $condition_op, $script_checker, $script_val, $condition_val ) {
		if ( 'empty' === $condition_op ) {
			$js_conditional = '!' . $script_checker . ' || ' . $script_val .  $this->rocket_get_operator( $condition_op );
		} elseif ( 'greater' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'less' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'greaterequal' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'lessequal' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'equal' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'contain' === $condition_op ) {
			$js_conditional = $script_checker . ' && (' . $script_val . '.includes(' . $condition_val . ') !== false && ' . $script_val . ' != "")';
		} elseif ( 'not_empty' === $condition_op ) {
			$js_conditional = $script_checker . ' && ' . $script_val . $this->rocket_get_operator( $condition_op );
		} elseif ( 'not_equal' === $condition_op ) {
			$js_conditional = '!' . $script_checker . ' || ' . $script_val . $this->rocket_get_operator( $condition_op ) . $condition_val;
		} elseif ( 'not_contain' === $condition_op ) {
			$js_conditional = '!' . $script_checker . ' || (' . $script_val . '.includes(' . $condition_val . ') === false && ' . $script_val . ' != "")';
		}
		return $js_conditional;
	}
}
