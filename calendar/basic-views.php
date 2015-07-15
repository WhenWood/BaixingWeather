<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar.css' rel='stylesheet' />
<link href='../fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='../lib/moment.min.js'></script>
<script src='../lib/jquery.min.js'></script>
<script src='../fullcalendar.min.js'></script>


<?php 

class CalData{

	function __construct($id, $title, $start, $level, $message){
		$this->id = $id;
		$this->title = $title;
		$this->start = $start;
		$this->level = $level;
		$this->message = $message;
	}

	public $id = null;
    public $title = null;
    public $start = null; // 日期
    public $level = null;
    public $message = null;
}

$cal_data = array(
	new CalData(1,'hehehe','2015-07-03', 1, 'werysdfgsdfg'), 	
	new CalData(2,'hehe','2015-07-05', 2, 'werysdfsfdsdfgsdfg'),
	new CalData(3,'hehehexx','2015-07-07', 3, 'wegdfgrysdfgsdfdsfsfg'),
	new CalData(4,'hxxehehe','2015-07-09', 1, 'werdgfdgdgfdfysdfgsdfdsfg'),
	new CalData(5,'hehhghhhhhehe','2015-07-11', 2, 'wegfdggfdgfdgfdgdfgdrysdfgsdffs')
	);

?>
<script>

	function getYYMMDD(date){
		var d=date;//new Date();
		return d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
	}

	function dateFormet(date){

	}

	$(document).ready(function() {



		$('#date').html(getYYMMDD(new Date()));

		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month'
			},

			buttonText: {
		        today: '今天',
		    },

		    dayClick: function(date, allDay, jsEvent, view) {
	            // $('#calendar').fullCalendar('clientEvents', function(event) {
	            //     if(event.start <= date && event.end >= date) {
	            //         return true;
	            //     }
	            //     return false;
	            // });
				//alert(date.toString());
				result = date.toISOString().slice(0, 10);
				$('#date').html(result);
				$('#title').val("");
				$('#message').html("");
    		},

			defaultDate: getYYMMDD(new Date()),
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2015-07-13',
					eventSources: {'id': 1,'level': 1 , 'message': 'hehehe'},
				},

				<?php foreach($cal_data as $row): ?>
				{
					title: '<?php echo $row->title?>',
					start: '<?php echo $row->start?>',
					eventSources: {'id': <?php echo $row->id?>,'level': <?php echo $row->level?> , 'message': '<?php echo $row->message?>'},
				},
				<?php endforeach; ?>
			],

			eventClick: function(event, jsEvent, view) {
					//alert(event.title);
					//alert(event.start.toISOString().slice(0, 10));
					//alert(event.eventSources.id);
					//alert(event.eventSources.level);
					//alert(event.eventSources.message);
					$('#title').val(event.title);
					$('#message').html(event.eventSources.message)

				}
		});
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {	
		margin: 0 auto;
		float: right;
		width: 70%;
		height: 100%;
	}
	#content {
		float: left;
		width: 30%;
	}

</style>
</head>
<body>
<div id="content">
	<form>
		<label>日期：</label>
		<br/>
		<label id="date"></label>
		<br/>
		<label>标题</label>
		<input type="text" id="title" name="title"/>
		<br/>
		<label>内容</label>
		<textarea id="message" name="text"></textarea>

		<br/>
		<input type="submit" name="submit" />
		<br/>
		<input type="submit" name="delete" value="delete"/>
	</form>
</div>
	<div id='calendar' ></div>

</body>
</html>
