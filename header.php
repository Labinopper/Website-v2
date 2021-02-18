<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.navbar {
  overflow: hidden;
  background-color: black;
  border-style: line;
  border-radius: 5px;
}

.navbar a {
  top: 140px;
  float: right;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
</head>
<body>

<div class="navbar">
  <a href="/logout.php">Logout</a>
  <div class="dropdown">
    <button class="dropbtn">Boardgames 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="/dashboard.php">Dashboard</a>
      <a href="/addgame.php">Games</a>
      <a href="/addplay.php">Plays</a>
      <a href="/purchases.php">Purchases</a>
      <a href="/kickstarters2.php">Add Kickstarter Project</a>
      <a href="/kickstarters.php">Add Kickstart Items</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Strava
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
        <a href="/strava/index.php">Dashboard</a>
        <a href="/strava/oauth-flow.php">oAuth Test</a>
        </div>
</div>
</div>