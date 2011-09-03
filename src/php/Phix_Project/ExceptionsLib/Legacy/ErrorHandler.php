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

class Legacy_ErrorHandler
{
        private $exceptionToThrow = null;
        
        public function run($callback)
        {
                // execute the code, inside our wrapper
                set_error_handler(array($this, 'handleLegacyError'));
                $callback();
                restore_error_handler();
                
                // throw any resulting exception
                if ($this->exceptionToThrow !== null)
                {
                        throw $this->exceptionToThrow;
                }
        }
        
        public function handleLegacyError($errno, $errstr, $errfile, $errline = 0, $errcontext = null)
        {
                // work out what kind of exception to throw
                switch($errno)
                {
                        case E_CORE_ERROR:
                        case E_CORE_WARNING:
                        case E_COMPILE_ERROR:
                        case E_COMPILE_WARNING:
                        case E_STRICT:
                        case E_DEPRECATED:
                        case E_USER_DEPRECATED:
                                // we do not want to throw an exception
                                // for any of these
                                $this->exceptionToThrow = null;
                                break;
                        
                        case E_ERROR:
                        case E_PARSE:
                        case E_WARNING:
                        case E_NOTICE:
                        case E_USER_ERROR:
                        case E_USER_NOTICE:
                                // this is the default if a user calls trigger_error() only with a message
                        case E_USER_WARNING:
                        case E_RECOVERABLE_ERROR:
                        default:
                                $this->exceptionToThrow = new Legacy_ErrorException($errno, $errstr, $errfile, $errline);
                }
        }
}