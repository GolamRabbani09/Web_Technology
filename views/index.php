<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Event Management System</title>
    <link rel="stylesheet" href="../css/ab.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <header class="main-header">
      <nav>
        <div class="logo">
          <i class="fas fa-calendar-alt"></i>
          <span>Event Management</span>
        </div>
        <div class="nav-buttons">
          <a href="login.php" class="btn login-btn">
            <i class="fas fa-sign-in-alt"></i> Login
          </a>
          <a href="register.php" class="btn register-btn">
            <i class="fas fa-user-plus"></i> Register
          </a>
        </div>
      </nav>
    </header>

    <main>
      <section class="hero">
        <div class="hero-content">
          <h1>Transform Your Events</h1>
          <p class="hero-subtitle">
            Create unforgettable experiences with our powerful event management
            platform
          </p>
          <div class="cta-buttons">
            <a href="register.php" class="btn primary-btn"
              >Start Your Journey</a
            >
            <a href="#features" class="btn secondary-btn">Explore Features</a>
          </div>
        </div>
        <div class="hero-image">
          <img
            src="https://www.kdmevents.co.uk/_cache/is-event-management-503x327.jpg"
            alt="Event Management"
          />
        </div>
      </section>

      <section id="features" class="features-section">
        <h2>Why Choose Us</h2>
        <div class="features-grid">
          <div class="feature-card">
            <i class="fas fa-calendar-check"></i>
            <h3>Easy Planning</h3>
            <p>
              Streamline your event planning process with our intuitive tools
            </p>
          </div>
          <div class="feature-card">
            <i class="fas fa-users"></i>
            <h3>Team Collaboration</h3>
            <p>Work seamlessly with your team members in real-time</p>
          </div>
          <div class="feature-card">
            <i class="fas fa-chart-line"></i>
            <h3>Analytics</h3>
            <p>Get detailed insights about your events' performance</p>
          </div>
        </div>
      </section>

      <section id="events" class="events-section">
        <h2>Featured Events</h2>
        <div class="event-grid">
          <div class="event-card">
            <div class="event-image">
              <img
                src="https://www.entrepreneurindia.com/tech25web/images/gallery/g11.jpg"
                alt="Tech Conference"
              />
              <div class="event-date">
                <span class="day">12</span>
                <span class="month">JUN</span>
              </div>
            </div>
            <div class="event-content">
              <h3>Tech Innovators Conference</h3>
              <p>Join industry leaders to explore the latest in technology.</p>
              <div class="event-details">
                <span><i class="fas fa-map-marker-alt"></i> Tech Center</span>
                <span><i class="fas fa-ticket-alt"></i> From $299</span>
              </div>
            </div>
          </div>
          <!-- Add more event cards here -->
        </div>
      </section>

      <section class="cta-section">
        <div class="cta-content">
          <h2>Ready to Get Started?</h2>
          <p>Join thousands of successful event organizers today</p>
          <a href="Registration_Form.php" class="btn primary-btn"
            >Create Your Event</a
          >
        </div>
      </section>
    </main>

    <footer>
      <div class="footer-content">
        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="#features">Features</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="Registration_Form.php">Register</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>Contact Us</h3>
          <p><i class="fas fa-envelope"></i> support@eventmanagement.com</p>
          <p><i class="fas fa-phone"></i> +1 234 567 890</p>
        </div>
        <div class="footer-section">
          <h3>Follow Us</h3>
          <div class="social-links">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Event Management. All rights reserved.</p>
      </div>
    </footer>
  </body>
</html>
