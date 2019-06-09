window.addEventListener('load', init);

let vresults = { "t":0, "pacum":0, "wrong": [] };
let nword = ppm = pacum = t = time = seconds = minutes = dec = 0;
let word = "";
let lastword = 144;
let training = chronometer = false;

let wordInput = document.getElementById('word-input');

function init() {
  wordInput  = document.getElementById('word-input');
  
  word = $(`#w-${nword}`).text();
  $('#current-word').text(word);
  $('#word-input').on("keydown",function (evt) {
    if (evt.which=='32') nextWord(this.value);
  });
  $('#word-input').on("keyup",function (evt) {
    if (!training) startTraining();
  });
  // Not working on jQuery: using DOM element
  wordInput.addEventListener("change", function (evt) { nextWord(this.value); });
}

function startTraining() {
  if (chronometer) resetChrono();
  resetPPM();
  chronometer = setInterval(chrono,100);
  training = true;
}
function endTraining(){
  $('#word-input').prop("disabled",true);
  clearInterval(chronometer);
  training = false;

  vresults['t']=t; vresults['pacum']=pacum;
  $('#vresults').val(JSON.stringify(vresults));
  $('#stadistics').submit();
}

function nextWord(value){
  entryword = value.trim();

  pacum += entryword.length;
  ppm = pacum*(600/t);
  $("#ppm").text(`${Math.round(ppm*100)/100} ppm`);

  if (word.trim() == entryword) {
    $('#wlog').text("·");
  } 
  else {
    vresults.wrong.push([word,entryword]);
    console.log(vresults);
    $('#wlog').text(`${word} X ${entryword}`);
  } 

  $(`#w-${nword}`).addClass("text-muted");
  nword++;
  if (nword<lastword){
    word = $(`#w-${nword}`).text();
    $('#current-word').text(word);
    $('#word-input').val("");
  } else endTraining();
}

function chrono() {
  t++; dec++;
  if (dec > 9) {
    dec = 0;
    seconds++;
  }
  if (seconds > 59) {
    seconds = 0;
    minutes++;
  }

  time = ((minutes < 10)?`0${minutes}`:`${minutes}`)
      + ((seconds < 10)?`:0${seconds}`:`:${seconds}`)
      + `.${dec}`;
  $("#time").text(time);
}

function resetChrono() {
  t = minutes = seconds = dec = 0;
  $("#time").text(`00:00.0`);
}
function resetPPM() {
  ppm = 0;
  $("#ppm").text(`0`);
}