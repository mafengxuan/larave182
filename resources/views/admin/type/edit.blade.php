@extends('admin.layout.index')


@section('content')

	@if (count($errors) > 0)
    <div class="mws-form-message error">
    		<font size="5">添加失败</font>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<div class="mws-panel grid_8">
    	<div class="mws-panel-header">
        	<span>类型修改</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" action="/admin/type/update" method="post">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">类型名称</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="tname" value="{{ $arr['tname'] }}">
        				</div>
        			</div>
        			
        		{{ csrf_field() }}
        		<div class="mws-button-row">
                    <input type="hidden" name="id" value="{{ $arr['id'] }}">
        			<input type="submit" value="修改" class="btn btn-danger">
        		</div>
        	</form>
        </div>    	
    </div>
@endsection