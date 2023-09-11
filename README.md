<!-- Improved compatibility of back to top link: See: https://github.com/othneildrew/Best-README-Template/pull/73 -->
<a name="readme-top"></a>

<!-- PROJECT SHIELDS -->
<!-- PROJECT LOGO -->
<br />
<div align="center">
  <h3 align="center">Laravel Crawler</h3>

  <p align="center">
    A crawler tool pulls together information from an url
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

This web crawler project, powered by Laravel, is designed to discover and collect data from website based on the url submitted by user. This Laravel-based crawler take a screenshot of the webpage and automates the process of extracting information such as title, description, and body.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

* [![Laravel][Laravel.com]][Laravel-url]
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

- PHP Version: Laravel requires PHP version 8 or higher

### Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/master/installation)

1. Clone the repository and switch to the repo folder
   ```sh
   git clone https://github.com/DevWWang/laravel-crawler.git
   cd laravel-crawler
   ```
2. Install all the dependencies and NPM packages
   ```sh
   composer install
   npm install
   ```
3. Copy the example env file and make the required configuration changes in the .env file
   ```sh
   cp .env.example .env
   ```
4. Generate a new application key
   ```sh
   php artisan key:generate
   ```
5. Run the database migrations (**Remember: set the database connection in .env before migrating**)
   ```sh
   php artisan migrate
   ```
6. Create the symbolic link,
   ```sh
   php artisan storage:link
   ```
7. Start the local development server
   ```sh
   php artisan serve
   ```
You can now access the project at http://localhost

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] url input to crawl
- [x] crawled result
    - [x] screenshot
    - [x] title with url as a link
    - [x] description
    - [x] ceated at (crawled at)
- [ ] Detail Page
    - [x] screenshot
    - [x] title with url as a link
    - [x] description
    - [ ] body
    - [x] ceated at (crawled at)

Bug to Fix:
Unable to dispaly XML file in view.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE -->
## Usage
Enter the url that you want to crawl at http://localhost
![Alt text](/public/usage-examples/url-request.png "Url Crawler Request Home Page")

Load the webpage and display the result
![Alt text](/public/usage-examples/url-result.png "Url Crawler Result")

Click `More Detail` to show all the information gathered
![Alt text](/public/usage-examples/url-detail.png "Url Crawler Result")

View Request History using `History` on top in navigation bar
![Alt text](/public/usage-examples/url-history.png "Url Crawler Result")

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- LICENSE -->
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* [Best-README-Template](https://github.com/othneildrew/Best-README-Template)
* [Img Shields](https://shields.io)
* [Browsershot](https://spatie.be/docs/browsershot/v2/introduction)
* [Hashids](https://github.com/vinkla/hashids)
* [Puppeteer](https://pptr.dev/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
