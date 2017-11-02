function openPortal() {
  jQuery("#CollapsiblePanelContent1").slideDown("fast");
  window.location.hash="CollapsiblePanel1"
  popCasBox();
}

function gotoPortal() {
  jQuery("#CollapsiblePanelContent1").slideToggle("slow");
  window.location.hash="CollapsiblePanel1"
  popCasBox();
}

function popCasBox() {
  o = document.getElementById('csunPortalLoginFrame');
  if (o) {
     o.src = "https://auth.csun.edu/cas/login?service=https://mynorthridge.csun.edu/psp/PANRPRD/?cmd=login&languageCd=ENG&embedform=true";
  }
  document.getElementById('userID').focus();
}
