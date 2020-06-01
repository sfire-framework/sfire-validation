<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */
 

$urls = [
	'example.com',
	'example.com:8080',
	'example.com/',
	'example.com/?foo=bar',
	'example.com/?foo=bar&baz=quez',
	'example.com/?foo=bar&baz=quez#fragment',
	'example.com/?foo=bar#fragment',
	'example.com/#fragment',
	'example.com/path',
	'example.com/path#fragment',
	'example.com/path?foo=bar',
	'example.com/path?foo=bar&baz=quez',
	'example.com/path?foo=bar#fragment',
	'example.com/path?foo=bar&baz=quez#fragment',
	'example.com:8080/?foo=bar',
	'example.com:8080/?foo=bar&baz=quez',
	'example.com:8080/?foo=bar&baz=quez#fragment',
	'example.com:8080/?foo=bar#fragment',
	'example.com:8080/#fragment',
	'example.com:8080/path',
	'example.com:8080/path#fragment',
	'example.com:8080/path?foo=bar',
	'example.com:8080/path?foo=bar&baz=quez',
	'example.com:8080/path?foo=bar#fragment',
	'example.com:8080/path?foo=bar&baz=quez#fragment',
	'user:pass@example.com',
	'user:pass@example.com:8080',
	'user:pass@example.com/',
	'user:pass@example.com/?foo=bar',
	'user:pass@example.com/?foo=bar&baz=quez',
	'user:pass@example.com/?foo=bar&baz=quez#fragment',
	'user:pass@example.com/?foo=bar#fragment',
	'user:pass@example.com/#fragment',
	'user:pass@example.com/path',
	'user:pass@example.com/path#fragment',
	'user:pass@example.com/path?foo=bar',
	'user:pass@example.com/path?foo=bar&baz=quez',
	'user:pass@example.com/path?foo=bar#fragment',
	'user:pass@example.com/path?foo=bar&baz=quez#fragment',
	'user:pass@example.com:8080/?foo=bar',
	'user:pass@example.com:8080/?foo=bar&baz=quez',
	'user:pass@example.com:8080/?foo=bar&baz=quez#fragment',
	'user:pass@example.com:8080/?foo=bar#fragment',
	'user:pass@example.com:8080/#fragment',
	'user:pass@example.com:8080/path',
	'user:pass@example.com:8080/path#fragment',
	'user:pass@example.com:8080/path?foo=bar',
	'user:pass@example.com:8080/path?foo=bar&baz=quez',
	'user:pass@example.com:8080/path?foo=bar#fragment',
	'user:pass@example.com:8080/path?foo=bar&baz=quez#fragment',
	'sub.example.com',
	'sub.example.com:8080',
	'sub.example.com/',
	'sub.example.com/?foo=bar',
	'sub.example.com/?foo=bar&baz=quez',
	'sub.example.com/?foo=bar&baz=quez#fragment',
	'sub.example.com/?foo=bar#fragment',
	'sub.example.com/#fragment',
	'sub.example.com/path',
	'sub.example.com/path#fragment',
	'sub.example.com/path?foo=bar',
	'sub.example.com/path?foo=bar&baz=quez',
	'sub.example.com/path?foo=bar#fragment',
	'sub.example.com/path?foo=bar&baz=quez#fragment',
	'sub.example.com:8080/?foo=bar',
	'sub.example.com:8080/?foo=bar&baz=quez',
	'sub.example.com:8080/?foo=bar&baz=quez#fragment',
	'sub.example.com:8080/?foo=bar#fragment',
	'sub.example.com:8080/#fragment',
	'sub.example.com:8080/path',
	'sub.example.com:8080/path#fragment',
	'sub.example.com:8080/path?foo=bar',
	'sub.example.com:8080/path?foo=bar&baz=quez',
	'sub.example.com:8080/path?foo=bar#fragment',
	'sub.example.com:8080/path?foo=bar&baz=quez#fragment',
	'mail.sub.example.com',
	'mail.sub.example.com:8080',
	'mail.sub.example.com/',
	'mail.sub.example.com/?foo=bar',
	'mail.sub.example.com/?foo=bar&baz=quez',
	'mail.sub.example.com/?foo=bar&baz=quez#fragment',
	'mail.sub.example.com/?foo=bar#fragment',
	'mail.sub.example.com/#fragment',
	'mail.sub.example.com/path',
	'mail.sub.example.com/path#fragment',
	'mail.sub.example.com/path?foo=bar',
	'mail.sub.example.com/path?foo=bar&baz=quez',
	'mail.sub.example.com/path?foo=bar#fragment',
	'mail.sub.example.com/path?foo=bar&baz=quez#fragment',
	'mail.sub.example.com:8080/?foo=bar',
	'mail.sub.example.com:8080/?foo=bar&baz=quez',
	'mail.sub.example.com:8080/?foo=bar&baz=quez#fragment',
	'mail.sub.example.com:8080/?foo=bar#fragment',
	'mail.sub.example.com:8080/#fragment',
	'mail.sub.example.com:8080/path',
	'mail.sub.example.com:8080/path#fragment',
	'mail.sub.example.com:8080/path?foo=bar',
	'mail.sub.example.com:8080/path?foo=bar&baz=quez',
	'mail.sub.example.com:8080/path?foo=bar#fragment',
	'mail.sub.example.com:8080/path?foo=bar&baz=quez#fragment',
	'user:pass@sub.example.com',
	'user:pass@sub.example.com:8080',
	'user:pass@sub.example.com/',
	'user:pass@sub.example.com/?foo=bar',
	'user:pass@sub.example.com/?foo=bar&baz=quez',
	'user:pass@sub.example.com/?foo=bar&baz=quez#fragment',
	'user:pass@sub.example.com/?foo=bar#fragment',
	'user:pass@sub.example.com/#fragment',
	'user:pass@sub.example.com/path',
	'user:pass@sub.example.com/path#fragment',
	'user:pass@sub.example.com/path?foo=bar',
	'user:pass@sub.example.com/path?foo=bar&baz=quez',
	'user:pass@sub.example.com/path?foo=bar#fragment',
	'user:pass@sub.example.com/path?foo=bar&baz=quez#fragment',
	'user:pass@sub.example.com:8080/?foo=bar',
	'user:pass@sub.example.com:8080/?foo=bar&baz=quez',
	'user:pass@sub.example.com:8080/?foo=bar&baz=quez#fragment',
	'user:pass@sub.example.com:8080/?foo=bar#fragment',
	'user:pass@sub.example.com:8080/#fragment',
	'user:pass@sub.example.com:8080/path',
	'user:pass@sub.example.com:8080/path#fragment',
	'user:pass@sub.example.com:8080/path?foo=bar',
	'user:pass@sub.example.com:8080/path?foo=bar&baz=quez',
	'user:pass@sub.example.com:8080/path?foo=bar#fragment',
	'user:pass@sub.example.com:8080/path?foo=bar&baz=quez#fragment',
	'user:pass@mail.sub.example.com',
	'user:pass@mail.sub.example.com:8080',
	'user:pass@mail.sub.example.com/',
	'user:pass@mail.sub.example.com/?foo=bar',
	'user:pass@mail.sub.example.com/?foo=bar&baz=quez',
	'user:pass@mail.sub.example.com/?foo=bar&baz=quez#fragment',
	'user:pass@mail.sub.example.com/?foo=bar#fragment',
	'user:pass@mail.sub.example.com/#fragment',
	'user:pass@mail.sub.example.com/path',
	'user:pass@mail.sub.example.com/path#fragment',
	'user:pass@mail.sub.example.com/path?foo=bar',
	'user:pass@mail.sub.example.com/path?foo=bar&baz=quez',
	'user:pass@mail.sub.example.com/path?foo=bar#fragment',
	'user:pass@mail.sub.example.com/path?foo=bar&baz=quez#fragment',
	'user:pass@mail.sub.example.com:8080/?foo=bar',
	'user:pass@mail.sub.example.com:8080/?foo=bar&baz=quez',
	'user:pass@mail.sub.example.com:8080/?foo=bar&baz=quez#fragment',
	'user:pass@mail.sub.example.com:8080/?foo=bar#fragment',
	'user:pass@mail.sub.example.com:8080/#fragment',
	'user:pass@mail.sub.example.com:8080/path',
	'user:pass@mail.sub.example.com:8080/path#fragment',
	'user:pass@mail.sub.example.com:8080/path?foo=bar',
	'user:pass@mail.sub.example.com:8080/path?foo=bar&baz=quez',
	'user:pass@mail.sub.example.com:8080/path?foo=bar#fragment',
	'user:pass@mail.sub.example.com:8080/path?foo=bar&baz=quez#fragment'
];