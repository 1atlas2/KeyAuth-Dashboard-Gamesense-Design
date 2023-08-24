<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Loading Screen</title>
<style>
  body {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    background-color: rgba(21, 21, 20, 1);
    font-family: "Clobber Grotesk Light", sans-serif;
    overflow: hidden;
  }
  
  .color-bar {
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, rgb(255, 0, 0), rgb(0, 255, 0), rgb(0, 0, 255));
  }
  
  .loading-container {
    text-align: center;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  
  .loading-text {
    font-size: 3rem;
    margin-top: 20px;
  }
  
  .loading-dots {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
  }
  
  .loading-dot {
    width: 10px;
    height: 10px;
    background-color: white;
    border-radius: 50%;
    margin: 0 5px;
    opacity: 0.6;
    animation: wave 1.5s infinite, pulse 1.5s infinite;
  }
  
  @keyframes wave {
    0%, 100% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px);
    }
  }
  
  @keyframes pulse {
    0%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.5);
    }
  }
</style>
</head>
<body>
  <div class="color-bar"></div>
  <div class="loading-container">
    <div class="loading-text">
      <span style="color: white;">game<span style="color: rgb(106, 188, 20);">sense</span></span>
    </div>
    <div class="loading-dots">
      <span class="loading-dot"></span>
      <span class="loading-dot"></span>
      <span class="loading-dot"></span>
    </div>
  </div>
</body>
</html>
