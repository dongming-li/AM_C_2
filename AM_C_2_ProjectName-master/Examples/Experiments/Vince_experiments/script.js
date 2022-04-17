//This is a JavaScript object literal, it is comparable to an enum, and it is used to define filenames of data sources on the server.
server = 
{
	default : 'default.php',
	admin_default: 'admin_default.php',
	new_user: 'get_new_user_page.php',
	tree: 'list_test.php'
}

//This is a JavaScript object literal, it is comparable to an enum, and it is used to define names of HTML elements on the page.
page = 
{
	content : 'contentpane',
	projects: 'messagesButtons',
	messages: 'projectsButtons',
	admin_content: 'admin_contentpane',
	admin_new_users: 'newUserButtons'
}

//This function should be called by the 'onload' attribute of the body element.
function initialize()
{
	//Get the default content pane from the server
	getElement(server.default, page.content);
}

function admin_initialize()
{
	//Get the default content pane from the server
	getElement(server.admin_default, page.admin_content);
}

//Updates the content pane with the given data
//@param element: The ID of the element to be updated
//@param data: The data to be placed in the element
function setElement(element, data)
{
	document.getElementById(element).innerHTML = data;
}

//Sends a request to the given PHP file on the server and fills the contentpane with the response when it arrives.
//@param source: The name of the source file to get data from
//@param destination : The ID of the element where the data should be placed
function getElement(source, destination)
{
	var request = new XMLHttpRequest();
	request.onreadystatechange = function()
	{
		if (XMLHttpRequest.DONE)	
		{
			setElement(destination, this.responseText);
		}
	}
	request.open("GET", source);
	request.send();	
}

//The following functions are 'onclick' functions. Any function required on any page should be included here and referenced like:
//<input type='button' value='[button_text]' onclick='functionToCallOnClick();'>

//Called when the 'Projects' header is clicked in the left sidebar
function clickProjects()
{
		getElement('vince_test.php', page.content);
	//setElement(page.content, "<p>Looks like you clicked the 'Projects' button.");
}

//Called when the 'Messages' header is clicked in the left sidebar
function clickMessages()
{
	setElement(page.content, "<p>Looks like you clicked the 'Messages' button.");
}

function clickNotifications()
{
	setElement(page.content, "<p>Looks like you clicked the 'Notifications' button.");
}

function clickSettings()
{
	setElement(page.content, "<p>Looks like you clicked the 'Settings' button.");
}

function click_user_in_manage_users()
{
	//setElement(page.admin_content, "manage_users.html");
}

//Called when the Create New User button is click on the admin frame
function clickNewUser()
{
	getElement(page.admin_content, server.new_user);
}
