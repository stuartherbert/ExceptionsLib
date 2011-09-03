<?php

/**
 * Copyright (c) 2011 Stuart Herbert.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     Phix_Project
 * @subpackage  ExceptionsLib
 * @author      Stuart Herbert <stuart@stuartherbert.com>
 * @copyright   2011 Stuart Herbert
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://www.phix-project.org
 * @version     @@PACKAGE_VERSION@@
 */

namespace Phix_Project\ExceptionsLib;

class E4xx_ForbiddenExceptionTest extends \PHPUnit_Framework_TestCase
{
        public function testCanThrowAsException()
        {
                // setup
                $caughtException = false;
                
                // action
                try
                {
                        throw new E4xx_ForbiddenException("test exception");
                }
                catch (E4xx_ForbiddenException $e)
                {
                        $caughtException = true;
                }
                
                // check the results
                $this->assertTrue($caughtException);
        }
        
        public function testThrownExceptionHasErrorCode502()
        {
                // setup
                $caughtException = false;
                $caughtCode      = 0;
                
                // action
                try
                {
                        throw new E4xx_ForbiddenException("test exception");
                }
                catch (E4xx_ForbiddenException $e)
                {
                        $caughtException = true;
                        $caughtCode      = $e->getCode();
                }
                
                // check the results
                $this->assertTrue($caughtException);     
                $this->assertEquals(403, $caughtCode);
        }
        
        public function testIsAnInternalServerErrorException()
        {
                // setup
                $caughtException = false;
                
                // action
                try
                {
                        throw new E4xx_ForbiddenException("test exception");
                }
                catch (E5xx_InternalServerErrorException $e)
                {
                        if ($e instanceof E4xx_ForbiddenException)
                        {
                                $caughtException = true;
                        }
                }
                
                // check the results
                $this->assertTrue($caughtException);     
        }
        
        public function testExceptionIncludesMessage()
        {
                // setup
                $caughtException = false;
                $caughtMessage   = null;
                $expectedMessage = "test exception";
                
                // action
                try
                {
                        throw new E4xx_ForbiddenException($expectedMessage);
                }
                catch (E4xx_ForbiddenException $e)
                {
                        $caughtException = true;
                        $caughtMessage   = $e->getMessage();
                }
                
                // check the results
                $this->assertTrue($caughtException);
                $parts = explode(': ', $caughtMessage);
                array_shift($parts);
                $retrievedMessage = implode(': ', $parts);
                $this->assertEquals($expectedMessage, $retrievedMessage);
                
        }
}