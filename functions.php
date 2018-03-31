<?php
/*************************************************************************************************/
/***                                                                                           ***/
/***   Functions File:                                                                         ***/
/***   -------------------------------------------------------------------------------------   ***/
/***   Classes:                                                                                ***/
/***                                                                                           ***/
/***     Theme Manager Class                                  Black_Knight_Theme_Manager       ***/
/***                                                                                           ***/
/***       Set Defaults                                                                        ***/
/***       Load_Dependencies                                                                   ***/
/***       Load Hooks and Filters                                                              ***/
/***                                                                                           ***/
/***                                                                                           ***/
/***     Theme Obj Class                                      Black_Knight_Theme_Obj           ***/
/***                                                                                           ***/
/***       Add Theme Support                                                                   ***/
/***       Starter Content                                                                     ***/
/***       Post Label                                                                          ***/
/***       Comment Form                                                                        ***/
/***                                                                                           ***/
/***                                                                                           ***/
/***     Theme Loader Class                                   Black_Knight_Theme_Loader        ***/
/***                                                                                           ***/
/***       Stores Hook and Filter Data                                                         ***/
/***       Run - Runs all hooks and filters                                                    ***/
/***                                                                                           ***/
/***                                                                                           ***/
/***     Theme Style Class                                    Black_Knight_Theme_Style         ***/
/***                                                                                           ***/
/***       Enqueue Scripts and Styles for Bootstrap                                            ***/
/***       Set Google Fonts                                                                    ***/
/***       Set Filter for Navigation li and anchor for bootstrap menus                         ***/
/***                                                                                           ***/
/***                                                                                           ***/
/***     Theme Widgets Class                                  Black_Knight_Theme_Widgets       ***/
/***                                                                                           ***/
/***       Initialize the sidebar widgets                                                      ***/
/***                                                                                           ***/
/***                                                                                           ***/
/***                                                                                           ***/
/*************************************************************************************************/

/* INCLUDE CLASS FILE FOR  */
include_once 'inc/class-black-knight-theme-manager.php';

$bkt2 = new Black_Knight_Theme_Manager();
$bkt2->run();


