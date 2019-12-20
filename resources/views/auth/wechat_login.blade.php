@extends('layouts.app')
@section('title', '微信扫码登录')

@section('content')
  <img src={{ $qrcodeUrl }} />
@stop
