// $(document).ready(function() {
//     let selectedRating = 0;
  
//     // Handle star click events
//     $(".star1").hover(function() {
//       selectedRating = $(this).data("rating");
//       // Remove gold color from stars before this one
//       $(".star").removeClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".star2").hover(function() {
//       selectedRating = $(this).data("rating");
//       // Remove gold color from stars before this one
//       $(".star").removeClass("selected");
//       $(".star1").addClass("selected");
//       $(this).addClass("selected");
//     });
//     $(".star3").hover(function() {
//         selectedRating = $(this).data("rating");
//         // Remove gold color from stars before this one
//         $(".star").removeClass("selected");
//         $(".star1").addClass("selected");
//         $(".star2").addClass("selected");
//         $(this).addClass("selected");
//     });
//     $(".star4").hover(function() {
//         selectedRating = $(this).data("rating");
//         // Remove gold color from stars before this one
//         // $(".star").removeClass("selected");
//         $(".star1").addClass("selected");
//         $(".star2").addClass("selected");
//         $(".star3").addClass("selected");
//         $(this).addClass("selected");
//     });
//     $(".star5").hover(function() {
//       selectedRating = $(this).data("rating");
//       // Remove gold color from stars before this one
//       $(".star").addClass("selected");
//     });
  
//     // Handle rate button click
//     $("#rateButton").click(function() {
//       if (selectedRating === 0) {
//         alert("Please select a rating.");
//         return;
//       }
      
//       // Send the selectedRating to your server (you'll need AJAX here)
//       // Example AJAX request:
      
//       $.ajax({
//         url: 'single.php?id=' + getUrlParameter('id'),
//         type: 'POST',
//         data: { rating: selectedRating}, // Replace postId with the actual post ID
//         success: function(response) {
//           // Handle the server response here (e.g., show a success message)
//           alert('Rating submitted successfully!');
//         },
//         error: function() {
//           // Handle any errors that occur during the AJAX request
//           alert('Error submitting rating.');
//         }
//       });
      
//       function getUrlParameter(name) {
//         name = name.replace(/[\[\]]/g, '\\$&');
//         var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
//         var results = regex.exec(window.location.href);
//         if (!results) return null;
//         if (!results[2]) return '';
//         return decodeURIComponent(results[2].replace(/\+/g, ' '));
//       }
      
//     });
//   });