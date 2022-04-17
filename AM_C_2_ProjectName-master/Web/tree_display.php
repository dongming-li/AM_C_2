<?php
	//Import required PHP files
	session_start();

	require 'database.php';
	require 'util.php';

	
	function process_children($self)
	{	
		$tree="";
		$table="<table><tr><th>Job Name</th><th>Description</th><tr>";
			
		$num_children=$self->num_rows;
		while($num_children>0)
		{
			$curChild=$self->fetch_assoc();
			$tree=$tree. "<li><a href=\"link\">
					<form action='tree_details.php' method='post'>
					<input type='hidden' name='node' value={$curChild["jobID"]}>
					<input type = submit value =\"{$curChild["jobname"]}\">
					</form>
				</a>";
			
			$grandChildren=get_children($curChild["jobID"]);
			if($grandChildren->num_rows>0)
			{
				$tree=$tree."<ul>";
				$tree=$tree.process_children($grandChildren);
				$tree=$tree."</ul>";
			}	
			$num_children=$num_children-1;
			$tree=$tree."</li>";		
		}
		return $tree;

	}
	
	function process_table($self)
	{	
		$table="";
			
		$num_children=$self->num_rows;
		while($num_children>0)
		{
			$curChild=$self->fetch_assoc();
			$table=$table. "<tr><td>".$curChild["jobname"]."</td><td>".$curChild["jobdesc"]."</td></tr>";
			
			$grandChildren=get_children($curChild["jobID"]);
			if($grandChildren->num_rows>0)
			{
				$table=$table.process_table($grandChildren);
			}	
			$num_children=$num_children-1;		
		}
		return $table;

	}

	//Define database parameters
	$servername = "mysql.cs.iastate.edu";
	$username = "dbu309amc2";
	$password = "x1cbBr23";
	$database = "db309amc2";
	data_set($servername, $username, $password, $database);
	$tree="";
	$result = data_usersList();
	if(isset($_POST['projName']))
	{
		$root=get_root_of_tree($_POST['projName']);
		$root=$root->fetch_assoc();
	}
	else{	
		$roots=get_roots();
	
		$rootQ = get_root_of_tree($roots->fetch_assoc()["jobname"]);
		$root=$rootQ->fetch_assoc();
	}
	$title = $root['jobname'];
	$_SESSION['project'] = $root['jobname'];

	$tree=$tree. "<ul> <li> <a href=\"link\"> 
		<form action='tree_details.php' method='post'>
			<input type='hidden' name='node' value={$root["jobID"]}>
			<input type = submit class='actionbutton' value =\"{$root["jobname"]}\">
		</form>
		</a>";
	$rootChildren=get_children($root["jobID"]);
	$tree=$tree. "<ul>";
	$tree=$tree.process_children($rootChildren);
	$tree=$tree. "</ul>";
	$tree=$tree. "</li></ul>";

	$desc=$root["jobdesc"];
	$table="<table><tr><th>Job Name</th><th>Completed</th></tr>";
	$table=$table.process_table(get_children($root["jobID"]))."</table>";

	$reqList="<ul>";
	$reqs=get_job_reqs($root["jobID"]);
	while($req=$reqs->fetch_assoc()["qualname"])
	{
		$reqList=$reqList."<li>".$req."</li>";
	}
	$reqList=$reqList."</ul>";
	
	$employees="<ul>";
	$employees=$employees.get_assigned($root["jobID"]);
	$employees=$employees."</ul>";

	$report = <<<HTML
		<!DOCTYPE html>
		<html>
			<head>
				<title> Project Report </title>
				<style>
					@import url('https://fonts.googleapis.com/css?family=Open+Sans');
					body
					{
						font-family: 'Open Sans', sans-serif;
					}
					tr:nth-child(even) 
					{
   						background-color: #bcbcbc;
					}
					td
					{
						border: 1px solid black;
						padding: 3px;
					}
					table 
					{
 						 border-collapse: collapse;
					}

				</style>
			</head>
			<body>
				<h1>$title</h1>
				<p>$desc</p>
				<br><hr><br>
				<h3>$title jobs</h3>
				$table
				<br>
				<h3>Project Requirements</h3>
				$reqList
				<br>
				<h3>Project Staff</h3>
				$employees
			</body>
		</html>
HTML;
	$_SESSION['report'] = $report;

	require 'navbar.php';

	
	$content = <<< HTML
		<head><link rel="stylesheet" href="styles.css"></head>
			<a href="download.php"> 
				<button type="button" class='actionbutton'> Download Report </button>
			</a>
		<div class="tree">
		$tree
		</div>
		</br></br></br></br></br>
HTML;
	require 'frame.php';

	echo $frame;

?>



