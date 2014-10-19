<script type="text/javascript"
src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="js/functions.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$(".panel").fadeIn('slow');
});
</script>

<div class="panel">
<br>
<br>
<h1>Music Box</h1>
<form id="file-submit" enctype="multipart/form-data" method="post" action="store">
<input id="filename" name="filename" type="file"/>
<h2>Audio Partition</h2>
<div class="form-control">
<input type="radio" name="opcion" id="partes" value="partes" required> Number of Parts
<input type="radio" name="opcion" id="minutos" value="minutos" required> Number of Minutes
<input type="text" name="duracion" id="duracion" required>
</div>
<button type="submit" id="cut" class="btn btn-success btn-lg active"> Cut </button>
<br>
</form>
@if(Session::has('message'))
<div class="alert alert-{{ Session::get('class') }}">{{ Session::get('message')}}</div>
@endif
</div>