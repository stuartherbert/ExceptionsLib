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

class Legacy_ErrorHandlerTest extends \PHPUnit_Framework_TestCase
{
        public function testCanInstantiate()
        {
                $obj = new Legacy_ErrorHandler();
                $this->assertTrue($obj instanceof Legacy_ErrorHandler);
        }
        
        public function testThrowsNoExceptionWhenNoError()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        $a = 2;
                };
                
                // action
                $caughtException = false;
                try
                {
                        $obj->run($func);
                }
                catch (Legacy_ErrorException $e)
                {
                        $caughtException = true;
                }
                
                // check
                $this->assertFalse($caughtException);
        }
        
        public function testCanWrapTriggerError()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        trigger_error("OMG we're all going to die!");
                };
                
                // action
                $caughtException = false;
                try
                {
                        $obj->run($func);
                }
                catch (Legacy_ErrorException $e)
                {
                        $caughtException = true;
                }
                
                // check
                $this->assertTrue($caughtException);
        }
        
        public function testCanWrapRuntimeError()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        mkdir('/proc/linux-sux');
                };
                
                // action
                $caughtException = false;
                try
                {
                        $obj->run($func);
                }
                catch (Legacy_ErrorException $e)
                {
                        $caughtException = true;
                }
                
                // check
                $this->assertTrue($caughtException);                
        }

        public function testThrowsNoExceptionForDeprecatedCalls()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        trigger_error("DEPRECATED!!", E_USER_DEPRECATED);
                };
                
                // action
                $caughtException = false;
                try
                {
                        $obj->run($func);
                }
                catch (Legacy_ErrorException $e)
                {
                        $caughtException = true;
                }
                
                // check
                $this->assertFalse($caughtException);
        }              
        
        public function testReturnsCallbackReturnValue()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        return 200;
                };
                
                // action
                $returned = $obj->run($func);
                
                // check
                $this->assertEquals(200, $returned);
        }
        
        public function testReturnsCallbackName()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        trigger_error("Oh dear");
                };
                
                // action
                $caughtException = false;
                try
                {
                        $obj->run($func);
                }
                catch (Legacy_ErrorException $e)
                {
                        $caughtException = $e;
                }
                
                // check
                $this->assertTrue($caughtException !== false);
                $this->assertEquals($func, $caughtException->getCallbackName());
        }
        
        public function testCallbackCanBeAClosure()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $func = function() {
                        return 200;
                };
                $returned = null;
                
                // action
                $returned = $obj->run($func);
                
                // check
                $this->assertEquals(200, $returned);
        }
        
        public function testCallbackCanBeAnObjectMethod()
        {
                // setup
                $obj = new Legacy_ErrorHandler();
                $returned = null;
                
                // action
                $returned = $obj->run(array($this, "successfulCallback"));
                
                // check
                $this->assertEquals(200, $returned);
        }
        
        public function successfulCallback()
        {
                return 200;
        }
}