<?php

/*
|--------------------------------------------------------------------------
| Message Send Listen Events
|--------------------------------------------------------------------------
|
| When event is fired, session "flash" the MessageBag object data
| so that it will be sent to the message/noty HTML view
|
*/

Illuminate\Support\Facades\Event::listen('message.send.warning', function(Illuminate\Support\MessageBag $message, $title = 'Warning:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'warning');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});

Illuminate\Support\Facades\Event::listen('message.send.success', function(Illuminate\Support\MessageBag $message, $title = 'Success:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'success');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});

Illuminate\Support\Facades\Event::listen('message.send.alert', function(Illuminate\Support\MessageBag $message, $title = 'Alert:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'alert');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});

Illuminate\Support\Facades\Event::listen('message.send.information', function(Illuminate\Support\MessageBag $message, $title = 'Information:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'information');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});

Illuminate\Support\Facades\Event::listen('message.send.error', function(Illuminate\Support\MessageBag $message, $title = 'Error:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'error');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});

Illuminate\Support\Facades\Event::listen('message.send', function(Illuminate\Support\MessageBag $message, $title = 'Alert:')
{
	Illuminate\Support\Facades\Session::flash('messages', $message);
	Illuminate\Support\Facades\Session::flash('messageType', 'alert');
	Illuminate\Support\Facades\Session::flash('messageTitle', $title);
	Illuminate\Support\Facades\Session::flash('messageText', implode(' ', $message->all()));
});