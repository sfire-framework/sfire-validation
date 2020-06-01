# sFire Validator

- [Introduction](#introduction)

- [Requirements](#requirements)

- [Installation](#installation)

  [Setup](#setup)

  - [Namespace](#namespace)
  - [Instance](#instance)
  - [Configuration](#configuration)

- [Usage](#usage)

  - [Adding fields for validation](#adding-fields-for-validation)
  - [Execute validation](#execute-validation)
  - [Validating arrays](#validating-arrays)
  - [Special "required" rules](#special-"required"-rules)
  - [Stopping on first validation failure (bail)](#stopping-on-first-validation-failure-(bail))
  - [Validation rules](#validation-rules)
  - [Using Middleware](#using-middleware)
  - [Custom validation](#custom-validation)
  - [ValidatorCallback](#validatorcallback)
  - [Conditionally Adding Rules](#conditionally-adding-rules)
  - [Combining fields](#combining-fields)
  - [Returning error messages](#returning-error-messages)
  - [Setting custom error messages](#setting-custom-error-messages)
  - [Returning the validated data](#returning-the-validated-data)

- [Examples](#examples)

  - [Validation form submit](#validation-form-submit)
  - [Using combine and middleware](#using-combine-and-middleware)

- [Notes](#notes)



## Introduction

sFire Validator provides several different approaches to validate your application's (incoming) data. It makes it a breeze to validate form submit values and files as well as combining multiple input for single validation. It supports middleware and custom validation rules and error messages. It will also returns the validated data for easy using the validated data i.e. inserting it into a database.



## Requirements

There are no requirements for this package.



## Installation

Install this package using [Composer](https://getcomposer.org/):

```shell script
composer require sfire-framework/sfire-validation
```



## Setup

### Namespace

```php
use sFire\Validation\Validator;
```



### Instance

```php
$validator = new Validator(array $validationData = null);
```

If a new validator is instantiated, the default `validationData` will be `$_POST` variable. But you may pass a custom `array` which needs to be validated:

```php
$validator = new Validator(['username' => 'Brenda', 'password' => '123']);
```



### Configuration

There are no configuration settings available for this package.



## Usage

### Adding fields for validation

By using the `field` method, you can add one or more field names for validation.

##### Syntax

```php
$validator -> field(string ...$fieldNames): FieldCollection
```

##### Example

```php
//You can add a single field name
$validator -> field('username');

//Or add multiple field names
$validator -> field('username', 'password', 'email'));
```



### Execute validation

sFire Validator comes with a arsenal of built-in validation rules. To execute validation, you may use the `execute()`, `fails()` or `passes()` method.

##### Example

```php
$validator -> field('username') -> minLength(5) -> maxLength(20);

$passes = $validator -> execute(); //Returns bool false/true

if(true === $validator -> fails()) {
	//Validation fails
}

if(true === $validator -> passes()) {
    //Validation success
}
```

sFire Validator will only run once to avoid i.e. multiple database lookups when executing the `execute()`, `fails()` or `passes()` methods.



### Validating arrays

You can also validate an `array` of fields. You can validate all the single elements in an `array` by using a `*` character. Be sure to validate the array as an `array` as well for proper error messages.

##### Example

```php
$input = ['email' => ['john@example.com', 'smith@example.com']];

$validator = new Validator($input);

$validator -> field('email') -> isArray(); //Check if the value is in array
$validator -> field('email.*') -> isEmail(); //Each value should be a valid email address
```



### Special "required" rules

Before explaining all the rules, you need to know the existence of the special "required" rules. These rules are special because you can enable and disable (bail) other rules based on if the input is empty or not.

For example, if a surname field is not required and thus may be empty, you can set the `required`  to boolean `false`. If the user leaves the input blank, it will not be validated.



A field is considered "empty" if one of the following conditions are true:

- The value is `null`.
- The value is an empty `string`.
- The value is an empty `array` or empty `countable` object.
- The value is an uploaded file with no path.



##### Example 1: Required

In this example, the `minLength()` rule will not be executed.

```php
$data = ['surname' => ''];
$validator = new Validator($data);
$valdiator -> field('surname') -> required(false) -> minLength(5);
```



##### Example 2: RequiredWith

In this example the `minLength` rule will be executed because the lastname field is also empty.

```php
$data = ['surname' => '', 'middlename' => '', 'lastname' => ''];
$validator = new Validator($data);
$valdiator -> field('surname') -> requiredWith('middlename', 'lastname') -> minLength(5);
```



##### Example 3: RequiredWithAll

In this example

```php

```



##### Example 4: RequiredWithout

In this example

```php

```




##### Example 5: RequiredWithoutAll

In this example

```php

```



### Stopping on first validation failure (bail)

Sometimes you may wish to stop running validation rules on an attribute  after the first validation failure. To do so, you can use the `bail()` method.

```php
$validator -> field('fieldname') -> bail() -> min(1) -> max(5);
```





### Validation rules

Below is a list with validation rules. 

**Global validation rules:**

|      |      |      |
| ---- | ---- | ---- |
|[After](#after)|[Before](#before)|[BeginsWith](#beginswith)|
|[Between](#between)|[Contains](#contains)|[Different](#different)|
|[Distinct](#distinct)|[EndsWith](#endswith)|[Equals](#equals)|
|[In](#in)|[IsAccepted](#isaccepted)|[IsAlpha](#isalpha)|
|[IsAlphaDash](#isalphadash)|[IsAlphaNumeric](#isalphanumeric)|[IsBool](#isbool)|
|[IsCountable](#iscountable)|[IsDate](#isdate)|[IsEmail](#isemail)|
|[IsEmpty](#isempty)|[IsFalse](#isfalse)|[IsInt](#isint)|
|[IsIp](#isip)|[IsIpPrivate](#isipprivate)|[IsIpPublic](#isippublic)|
|[IsIpV4](#isipv4)|[IsIpV6](#isipv6)|[IsJson](#isjson)|
|[IsLength](#islength)|[IsMacAddress](#ismacaddress)|[IsNumber](#isnumber)|
|[IsScalar](#isscalar)|[IsString](#isstring)|[IsTrue](#istrue)|
|[IsUrl](#isurl)|[LengthBetween](#lengthbetween)|[Max](#max)|
|[MaxLength](#maxlength)|[MaxWords](#maxwords)|[Min](#min)|
|[MinLength](#minlength)|[MinWords](#minwords)|[NotContains](#notcontains)|
|[NotIn](#notin)|[Regex](#regex)|[Same](#same)|
|[Present](#present)|[Words](#words)|

**Array validation rules:**

|                       |                               |                       |
| --------------------- | ----------------------------- | --------------------- |
| [Count](#count)       | [CountBetween](#countbetween) | [CountMax](#countmax) |
| [CountMin](#countmin) | [IsEmpty](#isempty)           | [IsArray](#isarray)   |

**File validation rules:**

|                               |                             |                         |
| ----------------------------- | --------------------------- | ----------------------- |
| [Dimensions](#dimensions)     | [Exists](#exists)           | [Extension](#extension) |
| [NotExtension](#notextension) | [MaxHeight](#maxheight)     | [MaxSize](#maxsize)     |
| [MaxWidth](#maxwidth)         | [MinHeight](#minheight)     | [MinSize](#minsize)     |
| [MinWidth](#minwidth)         | [SizeBetween](#sizebetween) |                         |



##### After

Check if the field under validation is after a given date. Optional you can pass a [date format](https://www.php.net/manual/en/function.date.php) as second argument. Default date format is `Y-m-d`.

```php
$validator -> field('fieldname') -> after('2000-01-01', 'Y-m-d');
```

See also the [Before](#before) rule.



##### Before

Check if the field under validation is before a given date. Optional you can pass a [date format](https://www.php.net/manual/en/function.date.php) as second argument. Default date format is `Y-m-d`.

```php
$validator -> field('fieldname') -> before('2030-01-01', 'Y-m-d');
```



##### Begins with

Check if the field under validation begins with a given value. 

```php
$validator -> field('fieldname') -> beginsWith('abc');
```



##### Between

Check if the field under validation is between the given *minimum* and *maximum*. 

```php
$validator -> field('fieldname') -> between(5, 10.5);
```

See also the [Min](#min) and [Max](#max) rules.



##### Contains

Check if the field under validation contains a given string.

```php
$validator -> field('fieldname') -> contains('abc');
```

See also the [NotContains](#notcontains) rule.



##### Count

When working with arrays, the field under validation contains a given amount of items. 

```php
$validator -> field('fieldname') -> count(10);
```

*Note: This only works on `arrays`. See the [isArray](#isarray) rule for combining this rule.*



##### CountBetween

When working with arrays, the field under validation contains the amount of items between the given *minimum* and *maximum*. 

```php
$validator -> field('fieldname') -> countBetween(5, 10);
```

*Note: This only works on `arrays`. See the [isArray](#isarray) rule for combining this rule.*



##### CountMax

When working with arrays, the field under validation contains less items than a given maximum amount. 

```php
$validator -> field('fieldname') -> countMax(10);
```

*Note: This only works on `arrays`. See the [isArray](#isarray) rule for combining this rule.*



##### CountMin

When working with arrays, the field under validation contains at least a given minimum amount of items. 

```php
$validator -> field('fieldname') -> countMin(5);
```

*Note: This only works on `arrays`. See the [isArray](#isarray) rule for combining this rule.*



##### Different

Check if the field under validation has not the same value of another field name

```php
$validator -> field('firstname' -> different('lastname');
```

See also the [Same](#same) rule.



##### Dimensions

When working with uploaded file images, the field under validation must have a given width and height in pixels. If the file is not readable or is not an image, it will return boolean `false`.

```php
$validator -> file('fieldname') -> dimensions(150, 300); //Width and height
```



##### Distinct

When working with arrays, the field under validation must not have any duplicate values.

```php
$validator -> field('fieldname') -> distinct();
```

*Note: This only works on `arrays`. See the [isArray](#isarray) rule for combining this rule.*



##### EndsWith

Check if the field under validation ends with a given value. 

```php
$validator -> field('fieldname') -> endsWith('abc');
```



##### Equals

Check if the field under validation is equal to a given value. A second parameter can be given if you want to check in strict mode. Strict mode lets you compare not only the value but also the type of the value. Default of strict mode is `boolean` `false`.

```php
$validator -> field('fieldname') -> equals('abc', true);
```



##### Exists

When working with uploaded files, the field under validation must physical exists in storage.

```php
$validator -> file('fieldname') -> exists();
```



##### Extension

When working with uploaded files, the field under validation must contain a given extension. You can give one extension or multiple separated by a comma.

```php
$validator -> field('fieldname') -> extension('jpg'); //You can also use ".jpg"
$validator -> field('fieldname') -> extension('jpg', 'png', 'gif'); //Or seperate them as parameters
```

See also the [NotExtension](#notextension) rule.



##### In

Check if the field under validation exists in a given `array`. 

```php
$validator -> field('fieldname') -> in(['a', 'b', 'c']);
```

See also the [notIn](#notin) rule.



##### IsAccepted

The field under validation must be *yes*, *on*, *1*, or *true*. This is useful for validating "Terms of Service" acceptance.

```php
$validator -> field('fieldname') -> isAccepted();
```



##### IsAlpha

Check if the field under validation only contains alpha characters (letters a-z, A-Z).

```php
$validator -> field('fieldname') -> isAlpha();
```



##### IsAlphaDash

Check if the field under validation only contains alphadash characters (letters a-z, A-Z, digits 0-9, dashes and underscores).

```php
$validator -> field('fieldname') -> isAlphaDash();
```



##### IsAlphaNumeric

Check if the field under validation only contains alphanumeric characters (letters a-z, A-Z and digits 0-9).

```php
$validator -> field('fieldname') -> isAlphaNumeric();
```



##### IsArray

Check if the field under validation is of the type `array`.

```php
$validator -> field('fieldname') -> isArray();
```



##### IsBool

Check if the field under validation is of the type `boolean`.

```php
$validator -> field('fieldname') -> isBool();
```



##### IsCountable

Check if the field under validation is countable, i.e. an `array`.

```php
$validator -> field('fieldname') -> isCountable();
```



##### IsDate

Check if the field under validation is a valid date. Optional you can pass a [date format](https://www.php.net/manual/en/function.date.php) as argument. Default date format is `Y-m-d`.

```php
$validator -> field('fieldname') -> isDate('Y-m-d');
```



##### IsEmail

Check if the field under validation is a valid email address.

```php
$validator -> field('fieldname') -> isEmail();
```



##### IsEmpty

Check if the field under validation is empty. A value is considered empty if:

- It is a empty string
- It is a empty array
- Equals to `null`

```php
$validator -> field('fieldname') -> isEmpty();
```



##### IsFalse

Check if the field under validation is of the type `boolean` and equals to `false`.

```php
$validator -> field('fieldname') -> isFalse();
```

See also the [IsTrue](#istrue) and [IsBool](#isbool) rules.



##### IsInt

Check if the field under validation is an integer number. A second parameter can be given if you want to check in strict mode. Strict mode lets you compare not only the value but also the type of the value. Default of strict mode is boolean `false`.

```php
$validator -> field('fieldname') -> isint(true);
```



##### IsIp

Check if the field under validation is a valid IPV4 or IPV6 address.

```php
$validator -> field('fieldname') -> isIp();
```

See also the [IsIpPrivate](#isipprivate), [IsIpPublic](#isippublic), [IsIpV4](#isipv4) and [IsIpV6](#isipv6) rules.



##### IsIpPrivate

Check if the field under validation is a valid private IPV4 or IPV6 address.

```php
$validator -> field('fieldname') -> isIpPrivate();
```

For IPV4 a private IP address is an IP in the range:

- 10.0.0.0 – 10.255.255.255
- 172.16.0.0 – 172.31.255.255
- 192.168.0.0 – 192.168.255.255

For IPV6 a private IP address is an IP starting with *FD* or *FC*.

See also the [IsIp](#isip), [IsIpPublic](#isippublic), [IsIpV4](#isipv4) and [IsIpV6](#isipv6) rules.



##### IsIpPublic

Check if the field under validation is a valid public IPV4 or IPV6 address. See the [IsIpPrivate](#Isipprivate) rule for IP address ranges that are private. All other IP address are public.

```php
$validator -> field('fieldname') -> isIpPublic();
```

See also the [IsIp](#isip), [IsIpPrivate](#isipprivate), [IsIpV4](#isipv4) and [IsIpV6](#isipv6) rules.



##### IsIpV4

Check if the field under validation is a valid public IPV4.

```php
$validator -> field('fieldname') -> isIpV4();
```

See also the [IsIp](#isip), [IsIpPrivate](#isipprivate), [IsIpPublic](#isippublic) and [IsIpV6](#isipv6) rules.



##### IsIpV6

Check if the field under validation is a valid public IPV6.

```php
$validator -> field('fieldname') -> isIpV6();
```

See also the [IsIp](#isip), [IsIpPrivate](#isipprivate), [IsIpPublic](#isippublic) and [IsIpV4](#isipv4) rules.



##### IsJson

Check if the field under validation is a valid JSON.

```php
$validator -> field('fieldname') -> isJson();
```



##### IsLength

Check if the field under validation has a character length equals to a given length. 

```php
$validator -> field('fieldname') -> isLength(10);
```

See also the [LengthBetween](#lengthbetween), [MaxLength](#maxlength) and [MinLength](#minlength) rules.



##### IsMacAddress

Check if the field under validation is a valid Mac Address according to the IEEE 802 standard.

```php
$validator -> field('fieldname') -> isMacAddress();
```



##### IsNumber

Check if the field under validation is a valid number. A second parameter can be given if you want to check in strict mode. Strict mode lets you compare not only the value but also the type of the value. Default of strict mode is boolean `false`.

```php
$validator -> field('fieldname') -> isNumber();
```



##### IsScalar

Check if the field under validation is a valid scalar value. Scalar variables are those containing an [integer](https://www.php.net/manual/en/language.types.integer.php),    [float](https://www.php.net/manual/en/language.types.float.php), [string](https://www.php.net/manual/en/language.types.string.php) or [boolean](https://www.php.net/manual/en/language.types.boolean.php). 

```php
$validator -> field('fieldname') -> isScalar();
```



##### IsString

Check if the field under validation is of the type `string`. 

```php
$validator -> field('fieldname') -> isString();
```



##### IsTrue

Check if the field under validation is of the type `boolean` and equals to `true`.

```php
$validator -> field('fieldname') -> isTrue();
```

See also the [IsFalse](#isfalse) and [IsBool](#isbool) rules.



##### IsUrl

Check if the field under validation is a valid URL. The protocol parameter can be set to boolean `true` if the URL must have the protocol included.

```php
$validator -> field('fieldname') -> url();
$validator -> field('fieldname') -> url(true); //Url must have a valid protocol like "https://"
```



##### LengthBetween

Check if the field under validation has a character length between a given *minimum* and *maximum* length. 

```php
$validator -> field('fieldname') -> lengthBetween(5, 20);
```

See also the [IsLength](#islength), [MaxLength](#maxlength) and [MinLength](#minlength) rules.



##### Max

Check if the field under validation is equal or less than a given *maximum*. Good for comparing numbers. 

```php
$validator -> field('fieldname') -> max(20.5);
```

See also the [Between](#between) and [Min](#min) rules.



##### MaxHeight

When working with uploaded file images, the field under validation may not exceed a given height in pixels. If the file is not readable or is not an image, it will return boolean `true`.

```php
$validator -> file('fieldname') -> maxHeight(250);
```

See also the [MinHeight](#minheight) and [Height](#height) rules.



##### MaxLength

Check if the field under validation has a given *maximum* character length. 

```php
$validator -> field('fieldname') -> maxLength(200);
```

See also the [LengthBetween](#lengthbetween), [IsLength](#islength) and [MinLength](#minlength) rules.



##### MaxSize

When working with uploaded files, the field under validation may not exceed a given file size in bytes. If the file is not readable, it will return boolean `true`.

```php
$validator -> file('fieldname') -> maxSize(102400); //100KB
```

See also the [MinSize](#minsize) , [Size](#size) and [SizeBetween](#sizebetween) rules.



##### MaxWidth

When working with uploaded file images, the field under validation may not exceed a given width in pixels. If the file is not readable or is not an image, it will return boolean `true`.

```php
$validator -> file('fieldname') -> maxWidth(250);
```

See also the [MinWidth](#minwidth) and [Width](#width) rules.



##### MaxWords

Check if the field under validation has a given *maximum* of words. By default a word is marked as a valid word if it contains at least 2 characters and only exists of alpha numeric characters (a-z A-Z 0-9).

**Example 1:**

Maximum of 100 words and each word should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word:

```php
$validator -> field('fieldname') -> maxWords(100);
```

**Example 2:**

Each word should contain at least 3 characters and should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word.

```php
$validator -> field('fieldname') -> maxWords(100, 3);
```

**Example 3:** 

Each word should contain at least 3 characters and may contain any character.

```php
$validator -> field('fieldname') -> maxWords(100, 3, false);
```

See also the [MinWords](#minwords) and [Words](#words) rules.



##### Min

Check if the field under validation is at least a given *minimum*. Good for comparing numbers. 

```php
$validator -> field('fieldname') -> min(5.52);
```

See also the [Between](#between) and [Max](#max) rules.



##### MinHeight

When working with uploaded file images, the field under validation must have at least a given height in pixels. If the file is not readable or is not an image, it will return boolean `false`.

```php
$validator -> file('fieldname') -> minHeight(100);
```

See also the [Height](#height) and [MaxHeight](#maxheight) rules.



##### MinLength

Check if the field under validation has a given *minimum* character length. 

```php
$validator -> field('fieldname') -> minLength(5);
```

See also the [LengthBetween](#lengthbetween), [IsLength](#islength) and [MaxLength](#maxlength) rules.



##### MinSize

When working with uploaded files, the field under validation must be a least a given file size in bytes. If the file is not readable, it will return boolean `false`.

```php
$validator -> file('fieldname') -> minSize(10240); //10KB
```

See also the [MaxSize](#maxsize), [Size](#size) and [SizeBetween](#sizebetween) rules.



##### MinWidth

When working with uploaded file images, the field under validation must have at least a given width in pixels. If the file is not readable or is not an image, it will return boolean `false`.

```php
$validator -> file('fieldname') -> minWidth(100);
```

See also the [Width](#width) and [MaxWidth](#maxwidth) rules.



##### MinWords

Check if the field under validation has a given *minimum* of words. By default a word is marked as a valid word if it contains at least 2 characters and only exists of alpha numeric characters (a-z A-Z 0-9).

**Example 1:**

Minimum of 10 words and each word should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word:

```php
$validator -> field('fieldname') -> maxWords(10);
```

**Example 2:**

Each word should contain at least 3 characters and should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word.

```php
$validator -> field('fieldname') -> maxWords(10, 3);
```

**Example 3:** 

Each word should contain at least 3 characters and may contain any character.

```php
$validator -> field('fieldname') -> maxWords(10, 3, false);
```

See also the [MaxWords](#maxwords) and [Words](#words) rules.



##### NotContains

Check if the field under validation does not contains a given string.

```php
$validator -> field('fieldname') -> notContains('abc');
```



##### NotExtension

When working with uploaded files, the field under validation may not contain a given extension. You can give one extension or multiple separated by a comma.

```php
$validator -> field('fieldname') -> notExtension('jpg'); //You can also use ".jpg"
$validator -> field('fieldname') -> notExtension('jpg', 'png', 'gif'); //Or seperate them as parameters
```

See also the [Extension](#extension) rule.



##### NotIn

Check if the field under validation may not exists in a given `array`. 

```php
$validator -> field('fieldname') -> notIn(['a', 'b', 'c']);
```

See also the [In](#in) rule.



##### Present

Check if the field under validation exists. Other than the required rule, this rule only checks if the field exists and thus may also be empty or `null`.

```php
$validator -> field('fieldname') -> present();
```



##### Regex

Check if the field under validation is valid compared to a given Regular Expression.

```php
$validator -> field('fieldname') -> regex('^[a-z]+$');
```



##### Same

Check if the field under validation has the same value of another field name.

```php
$validator -> field('password' -> same('password_repeat');
```

See also the [Different](#different) rule.



##### Size

When working with uploaded files, the field under validation must have a given file size in bytes. If the file is not readable, it will return boolean `false`.

```php
$validator -> file('fieldname') -> size(10240); //10KB
```

See also the [MinSize](#minsize), [MaxSize](#maxsize) and [SizeBetween](#sizebetween) rules.



##### SizeBetween

When working with uploaded files, the field under validation must have a file size in bytes between a given *minimum* and *maximum*. If the file is not readable it will return boolean `false`.

```php
$validator -> file('fieldname') -> sizeBetween(1024, 10240); //1KB and 10KB
```

See also the [MinSize](#minsize), [MaxSize](#maxsize) and [Size](#size) rules.



##### Words

Check if the field under validation has a given amount of words. By default a word is marked as a valid word if it contains at least 2 characters and only exists of alpha numeric characters (a-z A-Z 0-9).

**Example 1:**

Exactly 10 words and each word should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word:

```php
$validator -> field('fieldname') -> words(10);
```


**Example 2:**

Each word should contain at least 3 characters and should only contain alpha numeric characters (a-z A-Z 0-9) before marked as a word.

```php
$validator -> field('fieldname') -> words(10, 3);
```


**Example 3:** 

Each word should contain at least 3 characters and may contain any character.

```php
$validator -> field('fieldname') -> words(10, 3, false);
```

See also the [MaxWords](#maxwords) and [MinWords](#minwords) rules.



### Using Middleware



### Custom validation

There are a lot of built-in validation rules, but if you  want for example check an e-mail address in a database, you have to  build your own validation rule. You can use the `extend()` method to build a custom validation rule.

This method will give you a `\sFire\Validation\Extend` object that add a custom `callable` function or add a `custom class method` to extend the validation. Both methods, needs to return a `boolean` type if validation succeeds or not.

Both will also receive the value, parameters and a [ValidatorCallback](#validatorcallback) object to use for validation.



##### Example 1: Extending with a callable function

```php
$data = ['username' => 'Brenda'];
$validator = new Validator($data);
$validator -> extend('existsInDb') -> callback(function($value, array $params, ValidatorCallback $validator): bool {

    $exists = false; //This should be the lookup in the database
    return $exists;
    
}) -> message('Username already exists');

$validator -> field('username') -> custom('existsInDb'); //Add the custom rule
```



##### Example 2: Extending with a method

In the example below the `method()` method is used to define the custom validation. This method accepts a namespace with class name and a method name as second argument.

```php
$data = ['username' => 'Brenda'];
$validator = new Validator($data);
$validator -> extend('existsInDb') -> method(User::class, 'checkUsername') -> message('Username already exists');
$validator -> field('username') -> custom('existsInDb'); //Add the custom rule
```

Create a User class with the given method name and sFire will use it while validating:

```php
class User {
	
	public function checkUsername($value, array $params, ValidatorCallback $validator): bool {
        $exists = false; //This should be the lookup in the database
	    return $exists;
    }
}
```

*Note: the `checkUsername()` method may also be declared `static`.*



### ValidatorCallback

When [extending](#custom-validation) the validation with custom rules, you receive a `\sFire\Validation\ValidatorCallback` object. This object contains a few methods to help you determine if the field under validation is valid or not:

```php
function($value, array $params, ValidatorCallback $validator): bool {
    
    $validator -> getValue(); //Returns the value of the field under validation
    $validator -> getRuleName(); //Returns the name of the rule
    $validator -> getFieldName(); //Returns the field name under validation
    $validator -> getParameters(); //Returns an array with used parameters
    $validator -> setMessage('Invalid value'); //Sets a custom error message
    $validator -> getMessage(); //Returns the error message
    $validator -> getValidationData(); //Returns all the data that needs to be validated
}
```

You may also user the `getValueByFieldName()` method to retrieve  the value of a different field name.

```php
function($value, array $params, ValidatorCallback $validator): bool {
	$validator -> getValueByFieldName('username'); //Returns the username field
}
```

To retrieve all the data that's under validation, you can use the `getValidationData()`:

```php
function($value, array $params, ValidatorCallback $validator): bool {
	$validator -> getValidationData(); //Returns an array with all the data under validation
}
```



### Conditionally Adding Rules



### Combining fields

Sometimes you need to check multiple input values as one value. sFire lets you combine them into a new value for validation using the `glue` or `format` method described below.

##### HTML

```html
<input type="text" name="year" value="1952">
<input type="text" name="month" value="28">
<input type="text" name="day" value="03">
```



#### Combining with the glue method

You can combine fields with the `glue()` method and give it a new field alias (in this case *date*) with the `alias()` method which you can use to specify a new validation rule:

```php
$validator = new Validator();
$validator -> combine('year', 'month', 'day') -> glue('-') -> alias('date');
$validator -> field('date') -> isdate('Y-m-d');
```



#### Combining with the format method

You can also combine multiple fields with the `format()` method for more control:

```php
$validator = new Validator($);
$validator -> combine('year', 'month', 'day') -> format('%s-%s/%s) -> name('date');
$validator -> field('date') -> isdate('Y-m/d');
```

Each `%s` is replaced with the specified input field name order.



### Returning error messages

Use the `errors()` method to return a `sFire\Validator\Errors\ErrorCollection` object. This object has a couple of methods which you can use to return validation error messages.



#### Check if one or multiple fields have errors

To check if a field has errors, you can use the `has()` method. This method returns a `boolean` and accepts one or more field names. By giving multiple field names, the method will only return boolean `true` if all the field names have errors.

```php
$validator -> errors() -> has('email'); //Returns boolean true/false
$validator -> errors() -> has('username', 'password'); //Returns boolean true/false
```



#### Retrieve all error messages

The `get()` method 

To retrieve all error messages, use the `all()` method in combination with the `get()` method. This will return an array with `sFire\Validation\Errors\ValidationError` objects.

```php
$validator -> errors() -> get() -> all();
$validator -> errors() -> get() -> first();
$validator -> errors() -> get() -> last();
$validator -> errors() -> get('username', 'password') -> all();
```

You may also use 

##### Example

```php
$messages = $validator -> errors() -> get() -> all();

foreach($messages as $message) {
    
}
```



```php
$validator -> errors() -> distinct();
```





### Setting custom error messages

You can set your own custom error messages by using the `messages()` method. This can be handy when using translations. The method accepts an array with messages. You can overwrite rule messages globally or set a message per rule and field name.



##### Example 1: Overwriting messages globally

The array key equals the name of the rule, while the value is a custom error message.

```php
$validator -> messages([
    'required' => 'This field is required',
    'max' => 'Maximum of 5 items',
]);
```



##### Example 2: Overwriting messages per field and rule name

The first layer array keys are the field names, while the second layer array keys are the name of the rule. 

```php
$validator -> messages([
    'product.*' => [
        'max' => 'Maximum of 5 items per product'
    ],
    'email' => [
        'required' => 'Email field is required'
    ]
]);
```



### Returning the validated data

After validation, you can retrieve the data that has been validated. This can be different than the given data, because it will only return the data where validation rules were applied.



##### Example 1: Returning only validated data

```php
$validator = new Validator(['username' => 'Brenda', 'password' => '123']);
$validator -> field('username') -> minLength(3) -> maxLength(10) -> isString();
$validator -> execute();
$validator -> getValidatedData() -> toArray(); //Returns Array('username' => 'Brenda')
```

By default the `getValidatedData()` method returns all the types of validated data which include:

- Form field
- File uploads
- [Combined fields](#combining-fields)



##### Example 2: Include and exclude specific types

You can include or exclude these types in the output:

```php
//Only include validated field names
$validator -> getValidatedData() -> fields() -> toArray(); 

//Only include validated uploaded files
$validator -> getValidatedData() -> files() -> toArray(); 

//Only include combined field names
$validator -> getValidatedData() -> combined() -> toArray();
```

You may also chain the methods:

```php
$validator -> getValidatedData() -> fields() -> files() -> combined() -> toArray();
```



##### Example 3: Returning validated data as stdClass

To return the validated data as a `stdClass`, you can use the `toObject()` method:

```php
$validator -> getValidatedData() -> toObject();
```



## Examples

### Validation form submit

```php
$_POST = [
    'name' => 'Brenda Morris', 
    'email' => 'brenda@domain.com', 
    'password' => 'password123', 
    'password2' => 'password123'
];

$validator = new Validator($_POST);
$validator -> field('name') -> required() -> lengthBetween(3, 20);
$validator -> field('email') -> required() -> maxLength(30) -> email();
$validator -> field('password') -> required() -> same('password2') -> lengthBetween(6, 20);

if($validator -> passes()) {
    //Validation passes
}
```



### Using combine and middleware

Combining multiple fields to one and execute for each unique field middleware.

```php
$_POST = [
    'day' => '28', 
    'month' => '3', 
    'year' => '1952'
];

$validator = new Validator($_POST);
$validator -> combine('year', 'month', 'day') -> glue('-') -> middleware(AddLeadingZero::class) -> name('date');
$validator -> field('date') -> required() -> isDate('Y-m-d');

if($validator -> passes()) {
    //Validation passes
}
```



Each module directory has a directory called `Middleware`. Within this directory there is a directory called `Validation` where you can save all your validation middleware. Below is an example of middleware that will add a leading zero if the value is below 10:

```php
namespace App\Middleware\Validation;

use sFire\Validation\MiddlewareAbstract;

class AddLeadingZero extends MiddlewareAbstract {
	
    //Add a leading zero for the current value
	public function execute(): void {
		$this -> setValue($this -> convert($this -> getValue()));
    }

    private function convert($value) {

    	if(is_numeric($value)) {
    		return $value;
    	}

    	if($value < 10 && $value >= 0) {
			return $value = '0' . (string) $value;
		}
		
		return $value;
    }
}
```



## Notes

There are no notes for this package.