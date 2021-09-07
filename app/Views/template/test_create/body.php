<div class="container-fluid mb-3">
<ul class="sortable-ul">
	<li><div>Вопрос 1</div></li>
	<li>
		<div>Вопрос 2</div>
		<ul>
			<li><div>
            <input type="text">
            </div></li>
			<li><div>Ответ 2.2</div></li>
			<li><div>Ответ 2.3</div></li>
			<li><div>Ответ 2.4</div></li>
		</ul>		
	</li>
	<li><div>Вопрос 3</div></li>
	<li><div>Вопрос 4</div></li>
</ul>
</div>

<style>
.sortable-ul {
	list-style-type: none; 
	margin: 10px auto; 
	padding: 0; 
	width: 500px;
}
.sortable-ul ul {
	list-style-type: none; 
	margin: 0 0 0 30px;
	padding: 0; 
}
.sortable-ul div {
	margin: 4px 0; 
	padding: 5px 10px; 
	font-size: 16px;
	background: #eee;
	border: 1px solid #e0e0e0;
	border-left: 8px solid #e0e0e0;
}

/* Стиль для перетаскиваемого элемента. */
.sortable-ul .ui-sortable-helper {
	opacity: 0.8;
}
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
$('.sortable-ul, .sortable-ul li > ul').sortable();
</script>