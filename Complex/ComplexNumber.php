<?php

namespace Complex;

use BadMethodCallException;
use InvalidArgumentException;

/**
 * @property-read float $Re Real part of complex number
 * @property-read float $Im Imaginary part of complex number
 *
 */
class ComplexNumber
{
    private float $Re;
    private float $Im;


    public function __construct(float $Re, float $Im)
    {
        $this->Re = $Re;
        $this->Im = $Im;
    }


    public function __toString()
    {
        if ($this->isReal()) {
            return (string) $this->Re;
        } else {
            $sign = $this->Im > 0 ? '+' : '';

            return (string) ($this->Re . $sign . $this->Im . 'i');
        }
    }


    public function __get(string $name)
    {
        return $this->$name;
    }



    public static function sum(self ...$numbers) : self
    {
        return self::calculate($numbers, 'add');
    }


    public static function difference(self ...$numbers) : self
    {
        return self::calculate($numbers, 'subtract');
    }


    public static function product(self ...$numbers) : self
    {
        return self::calculate($numbers, 'multiply');
    }


    public static function quotient(self ...$numbers) : self
    {
        return self::calculate($numbers, 'divide');
    }


    private static function calculate(array $numbers, string $method) : self
    {
        if (count($numbers) < 2) {
            throw new BadMethodCallException("Method {$method} requires at least 2 arguments");
        }

        $base = clone array_shift($numbers);

        foreach ($numbers as $number) {
            $base->$method($number);
        }

        return $base;
    }


    public function add(self $number) : self
    {
        $this->Re += $number->Re;
        $this->Im += $number->Im;

        return $this;
    }


    public function subtract(self $number) : self
    {
        $this->Re -= $number->Re;
        $this->Im -= $number->Im;

        return $this;
    }


    public function multiply(self $number) : self
    {
        $Re = $this->Re * $number->Re - $this->Im * $number->Im;
        $Im = $this->Re * $number->Im + $this->Im * $number->Re;

        $this->Re = $Re;
        $this->Im = $Im;

        return $this;
    }


    public function divide(self $number) : self
    {
        if ($number->isZero()) {
            throw new InvalidArgumentException('Division by zero');
        }

        $numeratorRe = $this->Re * $number->Re + $this->Im * $number->Im;
        $numeratorIm = $this->Im * $number->Re - $this->Re * $number->Im;
        $denominator = $number->Re ** 2 + $number->Im ** 2;

        $this->Re = $numeratorRe / $denominator;
        $this->Im = $numeratorIm / $denominator;

        return $this;
    }


    public function isReal() : bool
    {
        return $this->isZero() || $this->Im == 0;
    }


    public function isComplex() : bool
    {
        return $this->isZero() || $this->Im != 0;
    }


    public function isZero() : bool
    {
        return $this->Re == 0 && $this->Im == 0;
    }
}
