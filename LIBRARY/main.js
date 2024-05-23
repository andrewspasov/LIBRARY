function fetchRandomQuote() {
  return fetch("http://api.quotable.io/random")
    .then((response) => response.json())
    .then((data) => data.content);
}

function updateFooterWithQuote() {
  const quoteFooter = document.getElementById("quoteFooter");

  fetchRandomQuote()
    .then((quote) => {
      quoteFooter.textContent = `"${quote}"`;
    })
    .catch((error) => {
      console.error("Error fetching quote:", error);
      quoteFooter.textContent = "Failed to fetch quote.";
    });
}

document.addEventListener("DOMContentLoaded", updateFooterWithQuote);

document.addEventListener("DOMContentLoaded", function () {
  const cardLinks = document.querySelectorAll(".card");
  cardLinks.forEach(function (card) {
    card.addEventListener("click", function (event) {
      event.preventDefault();

      var href = card.getAttribute("href");

      window.location.href = href;
    });
  });
});
