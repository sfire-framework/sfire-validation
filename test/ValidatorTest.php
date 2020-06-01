<?php
/*
- Chaining rules
- All the rules
- Middleware
- Custom rule class
- Retrieving error messages
- Returning Validation data
- Custom messages
- Bail rules
- Required
- Testing wildcards *
*/








/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sFire\Validation\Validator;
use sFire\Validation\ValidatorCallback;


/**
 * Class ValidatorTest
 */
final class ValidatorTest extends TestCase {


    /**
     * Setup
     * @return void
     */
    public function setUp(): void {

        <input type="file" name="file[]">
        <input type="file" name="file[]">

        //Mocking uploaded file
        $_FILES = [

            'file' => [

                'name' => [

                    'logo-1.png',
                    'logo-2.png'
                ],
                'type' => [

                    'image/png',
                    'image/png'
                ],
                'tmp_name' => [

                    './test/assets'. DIRECTORY_SEPARATOR .'logo-1.png',
                    './test/assets'. DIRECTORY_SEPARATOR .'logo-2.png'
                ],
                'error' => [

                    '0',
                    '0'
                ],
                'size' => [

                    '4992',
                    '15238'
                ]
            ]
        ];
    }


    /**
     * Testing combining fields together
     * @return void
     */
    public function testCombine(): void {

        //Test combining fields with expected date format
        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];
        
        $validator = new Validator($data);
        $validator -> combine('year', 'month', 'day') -> glue('-') -> alias('date');
        $validator -> field('date') -> isDate('Y-m-d');
        
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        $this -> assertFalse($validator -> fails());


        //Test combining fields with different expected date format
        $data = ['year' => '1952', 'month' => '03', 'day' => '28'];
        
        $validator = new Validator($data);
        $validator -> combine('year', 'month', 'day') -> glue('-') -> alias('date');
        $validator -> field('date') -> isDate('d-m-Y');
        
        $this -> assertFalse($validator -> passes());
        $this -> assertTrue($validator -> fails());


        //Test combining fields with missing expected fields
        $data = ['year' => '1952', 'month' => '03'];
        
        $validator = new Validator($data);
        $validator -> combine('year', 'month', 'day') -> glue('-') -> alias('date');
        $validator -> field('date') -> isDate('Y-m-d');
       
        $this -> assertFalse($validator -> passes());
        $this -> assertTrue($validator -> fails());
    }


    /**
     * Testing bailing other rules
     * @return void
     */
    public function testBail(): void {

        $validator = new Validator(['number' => 5]);
        $validator -> bail(true);
        $validator -> field('number') -> isInt() -> between(0, 10);
        $this -> assertTrue($validator -> passes());


        $validator = new Validator(['number' => 25.52]);
        $validator -> bail(true);
        $validator -> field('number') -> isInt() -> between(0, 10);
        $this -> assertFalse($validator -> passes());
        $this -> assertCount(1, $validator -> errors() -> get() -> all());


        $validator = new Validator(['number' => 25.52]);
        $validator -> bail(false);
        $validator -> field('number') -> isInt() -> between(0, 10);
        $this -> assertFalse($validator -> passes());
        $this -> assertCount(2, $validator -> errors() -> get() -> all());


        $validator = new Validator(['number' => 25.52, 'string' => '']);
        $validator -> field('number') -> bail(true) -> isInt() -> between(0, 10);
        $validator -> field('string') -> isInt() -> between(0, 10);
        $this -> assertFalse($validator -> passes());
        $this -> assertCount(3, $validator -> errors() -> get() -> all());


        $validator = new Validator(['number' => 25.52, 'string' => '']);
        $validator -> field('number') -> bail(true) -> isInt() -> between(0, 10);
        $validator -> field('string') -> bail(false) -> isInt() -> between(0, 10);
        $this -> assertFalse($validator -> passes());
        $this -> assertCount(3, $validator -> errors() -> get() -> all());
    }

    /*
    public function testValidatedData() {

        $validator = new Validator(['username' => 'Kris']);
        $validator -> field('username') -> required() -> isString() -> lengthBetween(3, 20);

        $this -> assertCount(0, $validator -> getValidatedData() -> toArray());
        $this -> assertTrue($validator -> passes());

        $this -> assertEquals(['username' => 'Kris'], $validator -> getValidatedData() -> toArray());
        $this -> assertEquals(['username' => 'Kris'], $validator -> getValidatedData() -> fields() -> uploaded() -> combined() -> files() -> toArray());


        $validator = new Validator(['year' => date('Y'), 'month' => date('m'), 'day' => date('d')]);
        $validator -> combine('year', 'month', 'day') -> glue('-') -> alias('date');
        $validator -> field('date') -> isDate('Y-m-d');
        $validator -> passes();

        $this -> assertEquals(['year' => date('Y'), 'month' => date('m'), 'day' => date('d'), 'date' => date('Y-m-d')], $validator -> getValidatedData() -> toArray());
        $this -> assertEquals(['year' => date('Y'), 'month' => date('m'), 'day' => date('d')], $validator -> getValidatedData() -> fields() -> toArray());
        $this -> assertEquals(['date' => date('Y-m-d')], $validator -> getValidatedData() -> combined() -> toArray());



        $validator = new Validator();
        $validator -> file('file.0') -> maxSize(5000);
        $validator -> passes();
        $this -> assertEquals([], $validator -> getValidatedData() -> combined() -> toArray());




        $validator = new Validator();
        $validator -> file('file.0') -> maxSize(5000);
        $validator -> passes();
        print_r($validator -> getValidatedData() -> toArray());
    }


    /**
     * Testing extending the validator with custom functions
     * @return void
     */
    public function testExtendingFunction(): void {

        //Test ValidatorCallback object
        $data      = ['key' => 'value'];
        $validator = new Validator($data);
        $validator -> extend('strlen') -> callback(function($value, array $params, ValidatorCallback $validator) use($data) {

            $this -> assertEquals($value, $validator -> getValue());
            $this -> assertEquals('value', $validator -> getValue());
            $this -> assertEquals($params, $validator -> getParameters());
            $this -> assertEquals(['min' => 10], $params);
            $this -> assertEquals('key', $validator -> getFieldName());
            $this -> assertEquals($data, $validator -> getValidationData());
            $this -> assertEquals(10, $validator -> getParameter('min'));
            $this -> assertEquals($value, $validator -> getValueByFieldName('key'));

            return strlen($value) > $params['min'];
        }) -> message('Invalid value');

        $validator -> field('key') -> custom('strlen', ['min' => 10]);
        $this -> assertFalse($validator -> passes());
        $this -> assertTrue($validator -> fails());


        //Test message outside function
        $data      = ['key' => 'value'];
        $validator = new Validator($data);
        $validator -> extend('strlen') -> callback(function($value, array $params, ValidatorCallback $validator){
            return strlen($value) > $params['min'];
        }) -> message('Invalid value');

        $validator -> field('key') -> custom('strlen', ['min' => 10]);
        $this -> assertFalse($validator -> execute());
        $this -> assertEquals('Invalid value', $validator -> errors() -> get() -> first() -> getMessage());


        //Test null message
        $data      = ['key' => 'value'];
        $validator = new Validator($data);
        $validator -> extend('strlen') -> callback(function($value, array $params, ValidatorCallback $validator){
            return strlen($value) > $params['min'];
        });

        $validator -> field('key') -> custom('strlen', ['min' => 10]);
        $this -> assertFalse($validator -> execute());
        $this -> assertEquals(null, $validator -> errors() -> get() -> first() -> getMessage());


        //Test message outside and inside function
        $data      = ['key' => 'value'];
        $validator = new Validator($data);
        $validator -> extend('strlen') -> callback(function($value, array $params, ValidatorCallback $validator) use($data) {

            $this -> assertEquals('Invalid value', $validator -> getMessage());
            $validator -> setMessage('message');
            $this -> assertEquals('message', $validator -> getMessage());

            return strlen($value) > $params['min'];
        }) -> message('Invalid value');

        $validator -> field('key') -> custom('strlen', ['min' => 10]);
        $this -> assertFalse($validator -> execute());
        $this -> assertEquals('message', $validator -> errors() -> get() -> first() -> getMessage());
    }


    /**
     * Testing extending the validator with custom classes and methods
     * @return void
     *//*
    public function testExtendingMethod(): void {

        $data = ['key' => 'value'];

        $validator = new Validator($data);
        $validator -> extend('strlen') -> method(StrlenCustomRule::class, 'isValid') -> message('Invalid value');
        $validator -> field('key') -> custom('strlen', 10);

        $this -> assertFalse($validator -> passes());
        $this -> assertTrue($validator -> fails());


        $data = ['key' => 'valuevaluevalue'];

        $validator = new Validator($data);
        $validator -> extend('strlen') -> method(StrlenCustomRule::class, 'isValid') -> message('Invalid value');
        $validator -> field('key') -> custom('strlen', 10);

        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule After
     * @return void
     */
    public function testRuleAfter(): void {

        //Should pass
        foreach([date('Y-m-d'), '1987-11-09', '3000-01-01'] as $data) {

            $validator = new Validator(['date' => $data]);
            $validator -> field('date') -> after('1952-03-28', 'Y-m-d');
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach(['', null, [], (object) [], 2552, true, '1952-03-27', '900-01-01'] as $data) {

            $validator = new Validator(['date' => $data]);
            $validator -> field('date') -> after('1952-03-28', 'Y-m-d');
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('date') -> after('1952-03-28');
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Before
     * @return void
     */
    public function testRuleBefore(): void {

        //Should pass
        foreach(['1987-11-09', '2000-01-01'] as $data) {

            $validator = new Validator(['date' => $data]);
            $validator -> field('date') -> before(date('Y-m-d'), 'Y-m-d');
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach(['', null, [], (object) [], 2552, true, date('Y-m-d'), '3000-01-01'] as $data) {

            $validator = new Validator(['date' => $data]);
            $validator -> field('date') -> before('1952-03-28', 'Y-m-d');
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('date') -> before('1952-03-28');
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Between
     * @return void
     */
    public function testRuleBetween(): void {

        //Should pass
        foreach(['50', 50, '50.52', 50.52] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> between(10, 100);
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], 2552, true, '2817334', -25, 5.52] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> between(10, 100);
            $this -> assertFalse($validator -> passes());
        }
    }


    /**
     * Testing the rule Contains
     * @return void
     */
    public function testRuleContains(): void {

        //Should pass
        foreach(['test', 'testtest', ' test ', 'another test'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> contains('test');
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], 2552, true, '2817334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> contains('test');
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> contains('test');
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Count
     * @return void
     */
    public function testRuleCount(): void {

        //Should pass
        foreach([[1, 2], ['a', 'b']] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> count(2);
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], ['a', 'b', 'c'], 2552, true, '2817334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> count(2);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> count(2);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule CountBetween
     * @return void
     */
    public function testRuleCountBetween(): void {

        //Should pass
        foreach([[1], [1, 2], [1, 2, 3]] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> countBetween(1, 3);
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], ['a', 'b', 'c', 'd'], 2552, true, '2817334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> countBetween(1, 3);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> countBetween(1, 3);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Different
     * @return void
     */
    public function testRuleDifferent(): void {

        //Should pass
        foreach(['testing', '', 'tes', ' test ', 0, null, true] as $data) {

            $validator = new Validator(['field' => $data, 'field2' => 'test']);
            $validator -> field('field') -> different('field2');
            $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
        }

        //Should fail
        $validator = new Validator(['field' => 'test', 'field2' => 'test']);
        $validator -> field('field') -> different('field2');
        $this -> assertFalse($validator -> passes());

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> different('field2');
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Dimensions
     * @return void
     */
    public function testRuleDimensions(): void {


        //Testing uploaded file
        $validator = new Validator();
        $validator -> file('file.0') -> dimensions(120, 120);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> dimensions(100, 120);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('file.0') -> dimensions(120, 100);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('file.0') -> dimensions(100, 100);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('non-existing') -> dimensions(120, 120);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Equals
     * @return void
     */
    public function testRuleEquals(): void {

        $validator = new Validator(['field' => 'test']);
        $validator -> field('field') -> equals('test');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator -> field('field') -> equals(['quez' => 'qwaz', 'foo' => 'bar']);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator -> field('field') -> equals(['foo' => 'bar', 'quez' => 'qwaz'], true);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => ['foo' => 'bar', 'quez' => 'qwaz']]);
        $validator -> field('field') -> equals(['quez' => 'qwaz', 'foo' => 'bar'], true);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator(['field' => 1]);
        $validator -> field('field') -> equals('1');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => 1]);
        $validator -> field('field') -> equals('1', true);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator(['field' => 1]);
        $validator -> field('field') -> equals(true);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => 1]);
        $validator -> field('field') -> equals(true, true);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Extension
     * @return void
     */
    public function testRuleExtension(): void {


        //Testing uploaded files
        $validator = new Validator();
        $validator -> file('file.0') -> extension('png');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> extension('.png');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> extension('.png', 'png', 'jpg', 'jpeg');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> extension('jpg', 'gif');
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('file.0') -> extension('.jpg');
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule In
     * @return void
     */
    public function testRuleIn(): void {

        //Should pass
        foreach([1, '1', true, 0, '0', false] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator->field('field')->in([0, 1]);
            $this->assertTrue($validator->passes());
        }

        //Should fail
        foreach([null, [], ['a', 'b', 'c', 'd'], 2552, '2817334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> in([1, 2, 3, 'a']);
            $this -> assertFalse($validator -> passes());
        }

        $validator = new Validator(['field' => '1']);
        $validator -> field('field') -> in([1, 2, 3, 'a'], true);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> field('field') -> in([1, 2, 3, 'a']);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule IsAccepted
     * @return void
     */
    public function testRuleIsAccepted(): void {

        //Should pass
        foreach(['yes', 'on', '1', 'true'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAccepted();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach(['', null, [], (object) [], 2552, true] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAccepted();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isAccepted();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isAlpha
     * @return void
     */
    public function testRuleIsAlpha(): void {

        //Should pass
        foreach(['abcdefg', 'sfire'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlpha();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], 2552, true, '2817334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlpha();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isAlpha();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isAlphaDash
     * @return void
     */
    public function testRuleIsAlphaDash(): void {

        //Should pass
        foreach(['abcdefg', 'sfire', '-sfire-', '123456', 123456, 'abcdefg123456-_'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlphaDash();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], true, '^', 'abcdef*'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlphaDash();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isAlphaDash();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isArray
     * @return void
     */
    public function testRuleIsAlphaNumeric(): void {

        //Should pass
        foreach(['abcdefg',' 123456', 123456, 'abcdefg123456'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlphaNumeric();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, [], (object) [], true, '^', 'abcdef*'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isAlphaNumeric();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isAlphaNumeric();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isArray
     * @return void
     */
    public function testRuleIsArray(): void {

        //Should pass
        $validator = new Validator(['field' => []]);
        $validator -> field('field') -> isArray();
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        //Should fail
        foreach([null, (object) [], true, '^', 'abcdef*'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isArray();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isArray();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isBool
     * @return void
     */
    public function testRuleIsBool(): void {

        //Should pass
        foreach([true, false] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isBool();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', 0, 1] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isBool();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isBool();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isDate
     * @return void
     */
    public function testRuleIsDate(): void {

        $validator = new Validator(['field' => date('Y-m-d')]);
        $validator -> field('field') -> isDate();
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => date('Y-m-d H:i:s')]);
        $validator -> field('field') -> isDate('Y-m-d H:i:s');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => date('Y-m-d H:i:s')]);
        $validator -> field('field') -> isDate();
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> field('field') -> isDate();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isEmail
     * @return void
     */
    public function testRuleIsEmail(): void {

        //Should pass
        foreach(['info@domain.com', 'in-Fo.domain@domain.com', 'info@domain.com.org.io'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isEmail();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', 0, 1, 'in-Fo.domain@ domain.com', 'info@@domain.com'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isEmail();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isEmail();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isFalse
     * @return void
     */
    public function testRuleIsFalse(): void {

        //Should pass
        $validator = new Validator(['field' => false]);
        $validator -> field('field') -> isFalse();
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        //Should fail
        foreach([null, (object) [], [], 'abcdef', 0, 1, true] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isFalse();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isFalse();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isInt
     * @return void
     */
    public function testRuleIsInt(): void {

        //Should pass
        foreach([0, 1, 52, -52, '0', '1', '52', '-52'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isInt();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '0', '1', '52', '-52', 5.52, '5.52', -5.52, '-5.52'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isInt(true);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isInt();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isIp
     * @return void
     */
    public function testRuleIsIp(): void {

        //Should pass
        foreach(['::1', '192.168.1.1', '127.0.0.1', '1.1.1.1', '255.255.255.255', '2001:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIp();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '255.255.255.256', '20010:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIp();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isIp();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isIpPrivate
     * @return void
     */
    public function testRuleIsIpPrivate(): void {

        //Should pass
        foreach(['::1', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpPrivate();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '1.1.1.1', '83.84.85.86'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpPrivate();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isIpPrivate();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isIpPublic
     * @return void
     */
    public function testRuleIsIpPublic(): void {

        //Should pass
        foreach(['1.1.1.1', '83.84.85.86'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpPublic();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '::1', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpPublic();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isIpPublic();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isIpv4
     * @return void
     */
    public function testRuleIsIpv4(): void {

        //Should pass
        foreach(['1.1.1.1', '83.84.85.86', '192.168.1.1', '127.0.0.1', '255.255.255.255'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpv4();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '::1', '2001:0db8:85a3:0000:0000:8a2e:0370:7334', '255.255.255.256'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpv4();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isIpv4();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isIpv6
     * @return void
     */
    public function testRuleIsIpv6(): void {

        //Should pass
        foreach(['::1', '2001:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpv6();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '1.1.1.1', '83.84.85.86', '192.168.1.1', '127.0.0.1', '255.255.255.255', '255.255.255.256', '20010:0db8:85a3:0000:0000:8a2e:0370:7334'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isIpv6();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isIpv6();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isJson
     * @return void
     */
    public function testRuleIsJson(): void {

        //Should pass
        foreach(['[]', '{"foo":"bar"}'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isJson();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, '{"foo":"bar"'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isJson();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isJson();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isLength
     * @return void
     */
    public function testRuleIsLength(): void {

        //Should pass
        foreach(['12345', 12345] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isLength(5);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isLength(5);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isLength(5);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule IsNumber
     * @return void
     */
    public function testRuleIsNumber(): void {

        //Should pass
        foreach(['12345', 12345, '5.52', 5.52, -5.52, '-5.52', 5.2829453113567E+269] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> IsNumber();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should pass
        foreach([12345, 5.52, -5.52, 5.2829453113567E+269] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> IsNumber(true);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach(['12345', '5.52', '-5.52'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> IsNumber(true);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, false, '5.2.5'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> IsNumber();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> IsNumber();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule present
     * @return void
     */
    public function testRulePresent(): void {

        //Should pass
        foreach([null, (object) [], [], 'abcdef', true, false, '5.2.5', ''] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> present();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> present();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isString
     * @return void
     */
    public function testRuleIsString(): void {

        //Should pass
        foreach(['abcdef', '12345'] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isString();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], true, 0, false] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isString();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isString();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule isTrue
     * @return void
     */
    public function testRuleIsTrue(): void {

        //Should pass
        $validator = new Validator(['field' => true]);
        $validator -> field('field') -> isTrue();
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        //Should fail
        foreach([null, (object) [], [], 0, false, 1] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isTrue();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isTrue();
        $this -> assertFalse($validator -> passes());
    }

    
    /**
     * Testing the rule isUrl
     * @return void
     */
    public function testRuleIsUrl(): void {

        //Require http urls
        require_once('./test/assets'. DIRECTORY_SEPARATOR .'http-urls.php');

        //Should pass
        foreach($urls as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isUrl();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should pass
        foreach($urls as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isUrl(true);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }


        //Require non http urls
        require_once('./test/assets'. DIRECTORY_SEPARATOR .'urls.php');

        //Should pass
        foreach($urls as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isUrl();
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach($urls as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isUrl(true);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        foreach([null, (object) [], [], 0, false, 1] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> isUrl();
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> isUrl();
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule lengthBetween
     * @return void
     */
    public function testRuleLengthBetween(): void {

        //Should pass
        foreach(['123', '1234', '12345', 123, 1234, 12345] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> lengthBetween(3, 5);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([null, (object) [], [], 'abcdef', true, 1, 12, '1', '12'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> lengthBetween(3, 5);
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> lengthBetween(3, 5);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Max
     * @return void
     */
    public function testRuleMax(): void {

        //Should pass
        foreach(['1', '2', '3', '4', '5', '-10', 1, 2, 3, 4, 5, -10, (object) [], [], 'abcdef', true] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> max(5);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach([6, '6'] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> max(5);
            $this -> assertFalse($validator -> passes());
        }

        //Should pass
        $validator = new Validator();
        $validator -> field('field') -> max(5);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule MaxHeight
     * @return void
     */
    public function testRuleMaxHeight(): void {

        $validator = new Validator();
        $validator -> file('file.0') -> maxHeight(120);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> maxHeight(100);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('non-existing') -> maxHeight(120);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule maxLength
     * @return void
     */
    public function testRuleMaxLength(): void {

        //Should pass
        foreach([null, (object) [], [], true, '1', '12', '123', '1234', '12345', 1, 12, 123, 1234, 12345] as $data) {

            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> maxLength(5);
            $this -> assertTrue($validator -> passes());
            $this -> assertFalse($validator -> fails());
        }

        //Should fail
        foreach(['abcdef', 123456] as $data) {
         
            $validator = new Validator(['field' => $data]);
            $validator -> field('field') -> maxLength(5);
            $this -> assertFalse($validator -> passes());
        }

        //Should pass
        $validator = new Validator();
        $validator -> field('field') -> maxLength(5);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule MaxSize
     * @return void
     */
    public function testRuleMaxSize(): void {

        $validator = new Validator();
        $validator -> file('file.0') -> maxSize(5000);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> maxSize(4000);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('non-existing') -> maxSize(5000);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule MaxWidth
     * @return void
     */
    public function testRuleMaxWidth(): void {

        $validator = new Validator();
        $validator -> file('file.0') -> maxWidth(120);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator();
        $validator -> file('file.0') -> maxWidth(100);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator();
        $validator -> file('non-existing') -> maxWidth(120);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }


    /**
     * Testing the rule maxWords
     * @return void
     */
    public function testRuleMaxWords(): void {

        $validator = new Validator(['field' => 'word1 word2 word3']);
        $validator -> field('field') -> maxWords(3);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => 'word1 word2 word3 word4']);
        $validator -> field('field') -> maxWords(3, 6);
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        $validator = new Validator(['field' => 'word1$ word2$ word3$ word4$']);
        $validator -> field('field') -> maxWords(3, 3, false);
        $this -> assertFalse($validator -> passes());

        $validator = new Validator(['field' => 'word1 word2 word3 word4']);
        $validator -> field('field') -> maxWords(3);
        $this -> assertFalse($validator -> passes());
    }


    /**
     * Testing the rule Same
     * @return void
     */
    public function testRuleSame(): void {

        //Should pass
        $validator = new Validator(['field' => 'test', 'field2' => 'test']);
        $validator -> field('field') -> same('field2');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());

        //Should fail
        foreach(['testing', '', 'tes', ' test ', 0, null, true] as $data) {

            $validator = new Validator(['field' => $data, 'field2' => 'test']);
            $validator -> field('field') -> same('field2');
            $this -> assertFalse($validator -> passes());
        }

        //Should fail
        $validator = new Validator();
        $validator -> field('field') -> same('field2');
        $this -> assertTrue($validator -> passes());
        $this -> assertFalse($validator -> fails());
    }
}