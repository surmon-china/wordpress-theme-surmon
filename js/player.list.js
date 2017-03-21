$(document).ready(function(){
	var qiniuCdnUrl = 'http://7xmwbu.com1.z0.glb.clouddn.com';
  var playlist = [
  	{
      title:"Time Will Tell",
	  artist:"X-Ray Dog",
      mp3: qiniuCdnUrl + "/Time_Will_Tell.mp3",
      poster: ""
	},{
      title:"Oceans",
	  artist:"Capo Production",
      mp3: qiniuCdnUrl + "/Oceans.mp3",
      poster: ""
	},{
      title:"Aurora",
	  artist:"Capo Production",
      mp3: qiniuCdnUrl + "/Aurora.mp3",
      poster: ""
	},{
      title:"To Be...",
	  artist:"Valentin",
      mp3: qiniuCdnUrl + "/To_Be.mp3",
      poster: ""
	},{
      title:"Butterfly Kiss",
	  artist:"DJ OKAWARI",
      mp3: qiniuCdnUrl + "/Butterfly-Kiss.mp3",
      poster: ""
	},{
      title:"Till The End",
	  artist:"Capozio",//http://sc.111ttt.com/up/mp3/93362/B435C9A8FE3F3B3EE816144E1E808C11.mp3
      mp3: qiniuCdnUrl + "/Till_The_End.mp3",
		  
      poster: ""
	},{
      title:"Journey",
	  artist:"Capozio",//http://sc.111ttt.com/up/mp3/163274/AB83F8A11821AD0488F674721B48EE11.mp3
      mp3: qiniuCdnUrl + "/Journey.mp3",
      poster: ""
	},{
      title:"Inspire",
      artist:"Capozio",//http://sc.111ttt.com/up/mp3/385723/FFE1CE1F4F2A694A6A3460A8EC22B64C.mp3
      mp3:qiniuCdnUrl + "/inspire.mp3",
	 
      poster: ""
    },{
      title:"Thaitsuki Roiyaru Sanmai Katana",
      artist:"DJ Vital Force",
      mp3:qiniuCdnUrl + "/Thaitsuki.mp3",
      poster: ""
    },{
      title:"Represent",
	  artist:"DJ OKAWARI",//http://sc.111ttt.com/up/mp3/112488/3E4BAAFF5799B3A286132C29ECE889DF.mp3
      mp3: "",
      poster: qiniuCdnUrl + "/Represent.mp3"
	}];
  
  var cssSelector = {
    jPlayer: "#jquery_jplayer",
    cssSelectorAncestor: ".music-player"
  };
  
  var options = {
    swfPath: "Jplayer.swf",
    supplied: "ogv, m4v, oga, mp3"
  };
  
  var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);
  
});