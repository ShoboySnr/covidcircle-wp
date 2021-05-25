needPopup.config.custom = {
  'removerPlace': 'outside',
  'closeOnOutside': true,
  onShow: function() {
    $('#homevideoplayer').simplePlayer({
      autoplay: 1,
      autohide: 1,
      border: 0,
      wmode:'opaque',
      enablejsapi: 1,
      modestbranding: 1,
      version: 3,
      hl:'en_US',
      rel: 0,
      showinfo: 0,
      hd: 1,
      iv_load_policy: 3,
    });
  },
  onHide: function() {
    console.log('needPopup is hidden');
  }
};
needPopup.init();


