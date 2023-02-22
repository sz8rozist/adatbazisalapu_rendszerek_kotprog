let dateTextInput = document.querySelectorAll(".ido");
for (let i = 0; i < dateTextInput.length; i++) {
  dateTextInput[i].addEventListener("keyup", function () {
    if (this.value.length > 5) {
      this.value = this.value.substring(0, 5);
    }
    if (this.value !== 0) {
      var key = event.keyCode || event.charCode;
      if (key !== 8 && key !== 46) {
        if (this.value.length === 2) {
          this.value += ":";
        }
      } else {
        value = [];
        if (this.value.slice(-1)[0] === ":") {
          for (let i = 0; i <= this.value.length - 2; i++) {
            value.push(this.value[i]);
          }
          this.value = value.join("");
        }
      }
    }
  });
}
