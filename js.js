
window.addEventListener('DOMContentLoaded', () => {
    const now = Date.now();
    const lastShown = localStorage.getItem('hireModalTimestamp');
  
    if (!lastShown || now - lastShown > 28800000) { // 8 hours
      setTimeout(() => {
        document.getElementById('whyHireModal').style.display = 'block';
        localStorage.setItem('hireModalTimestamp', now);
      }, 10000); // Show after 10 seconds
    }
  
    document.querySelector('.modal .close').addEventListener('click', () => {
      document.getElementById('whyHireModal').style.display = 'none';
    });
  });
  
