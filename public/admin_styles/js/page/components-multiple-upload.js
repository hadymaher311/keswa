"use strict";

var dropzone = new Dropzone("#mydropzone", {
  url: "#",
  addRemoveLinks: true,
  autoProcessQueue: false,
  dictDefaultMessage: "Hello",
});

var minSteps = 6,
  maxSteps = 60,
  timeBetweenSteps = 100,
  bytesPerStep = 100000;

dropzone.on("addedfile", function(file) {
  /* Maybe display some more file information on your page */
  console.log(dropzone.files)
});
