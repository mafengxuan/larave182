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
        	<span>商品修改</span>
        </div>
        <div class="mws-panel-body no-padding">
        	<form class="mws-form" action="/admin/goods/update" method="post">
        		<div class="mws-form-inline">
        			<div class="mws-form-row">
        				<label class="mws-form-label">商品名</label>
        				<div class="mws-form-item">
        					<input disabled type="text" class="small" name="gname" value="{{ $arr['gname'] }}">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">商品描述</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="content" value="{{ $arr['content'] }}">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">商品数量</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="num" value="{{ $arr['num'] }}">
        				</div>
        			</div>
        			<div class="mws-form-row">
        				<label class="mws-form-label">商品价格</label>
        				<div class="mws-form-item">
        					<input type="text" class="small" name="price" value="{{ $arr['price'] }}">
        				</div>
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