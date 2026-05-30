# SKANEDA Information Platform API

Backend API powering a dynamic school information platform built with Laravel. The system delivers school content, announcements, achievements, events, facilities, community discussions, and career opportunities through a centralized REST API architecture.

Designed to support dynamic content delivery, role-based access control, caching, background jobs, and scalable data management.

---

## Overview

Most school websites are built as static pages with hardcoded content.

This project was designed to provide a centralized backend service where all content is managed dynamically through APIs and consumed by frontend applications.

The platform supports multiple content domains including news publishing, achievements, facilities, extracurricular activities, discussion forums, career opportunities, and event management.

Beyond simple CRUD operations, the project incorporates role-based permissions, audit tracking, caching mechanisms, queue processing, and relational data modeling.

---

## Project Scope

My primary responsibility in this project was backend API development, including:

- Database design
- REST API implementation
- Authentication & authorization
- Business logic development
- Redis integration
- Queue processing

The frontend application was developed separately and consumes the APIs provided by this repository.

---

## Project Statistics

* 20+ Database Tables
* 10+ API Modules
* Role-Based Authentication
* Redis Cache Integration
* Queue-Based Background Processing
* Audit Trail Implementation
* RESTful API Architecture
* Dynamic Content Delivery System

---

## Problem

Traditional school websites often suffer from several limitations:

* Hardcoded content updates
* Difficult content maintenance
* Poor scalability
* Limited user interaction
* Lack of centralized data management

As content volume grows, maintaining consistency across multiple pages becomes increasingly difficult.

---

## Solution

SKANEDA Information Platform API centralizes all school-related information into a single backend service.

The platform exposes RESTful APIs for:

* News Publishing
* Achievement Management
* Event Scheduling
* Facility Information
* Extracurricular Activities
* Discussion Forums
* Career Opportunities
* Feedback Collection

This approach allows frontend applications to consume dynamic data without requiring direct database access.

---

## Core Features

### Authentication & Authorization

* Laravel Sanctum Authentication
* Protected API Routes
* Role-Based Access Control
* Session Management

### News Management

* News Publishing
* Slug-Based Routing
* View Tracking
* Soft Delete Support

### Achievement Management

* Achievement Categories
* Achievement Publishing
* Achievement Galleries

### Event Management

* School Agendas
* Event Scheduling
* Date-Based Content Delivery

### Facilities Management

* Facility Catalog
* Multiple Facility Images
* Facility Availability Status

### Extracurricular Activities

* Extracurricular Listings
* Activity Status Management

### Community Features

* Discussion Forums
* Forum Chat System
* Community Interaction APIs

### Career Center

* Job Listings
* Job Categories
* Registration Links
* Opportunity Management

### Feedback System

* Public Feedback Submission
* Feedback Collection APIs

### Analytics

* News View Tracking
* Engagement Monitoring

---

## System Architecture

Client Applications<br>
↓<br>
Laravel REST API<br>
↓<br>
Redis Cache Layer<br>
↓<br>
MySQL Database<br>
↓<br>
Queue Processing System

---

## Database Design

The database was designed around multiple interconnected content domains.

### User & Access Management

* Users
* Roles
* Statuses
* Personal Access Tokens

Supports authentication and authorization workflows across the platform.

---

### Content Domain

* News
* Achievements
* Achievement Categories
* Agendas
* Facilities
* Facility Images
* Extracurricular Activities

Responsible for delivering dynamic school content.

---

### Community Domain

* Forums
* Chats

Enables discussion and interaction between users.

---

### Career Domain

* Job Listings
* Job Types
* Partners

Provides job vacancy information and external registration opportunities.

---

### Analytics Domain

* News Views

Tracks content engagement metrics.

---

## Engineering Decisions

### Why Laravel?

Laravel provides a mature ecosystem for building scalable APIs while offering authentication, queues, caching, and database abstraction out of the box.

### Why Redis?

Redis was introduced to support caching and improve response times for frequently accessed data.

### Why Queue Processing?

Background jobs help offload non-critical operations from the main request lifecycle, improving application responsiveness.

### Why Audit Tracking?

Several entities maintain:

* created_by
* updated_by
* deleted_by

This provides content ownership visibility and modification traceability.

---

## Technical Challenges

### Managing Multiple Content Domains

Challenge:

The platform manages different types of content including news, achievements, facilities, agendas, forums, and job listings.

Solution:

A modular database structure was designed to separate responsibilities while maintaining relational consistency.

---

### Data Consistency

Challenge:

Multiple content entities require consistent lifecycle management.

Solution:

Soft deletes and audit tracking were implemented across major content modules.

---

### Performance Optimization

Challenge:

Repeated database queries can impact response times.

Solution:

Redis caching was introduced for frequently accessed data.

---

## Lessons Learned

Through this project I gained practical experience with:

* REST API Development
* Laravel Sanctum Authentication
* Role-Based Authorization
* Relational Database Design
* Redis Caching
* Queue Processing
* Audit Trail Implementation
* Content Management Architecture
* API Resource Design
* Production-Oriented Backend Development

---

## Technology Stack

### Backend

* Laravel
* PHP

### Database

* MySQL

### Caching

* Redis

### Authentication

* Laravel Sanctum

---

## Screenshots

### Homepage

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/d0118286-ee08-4970-b739-0c13e2c293c4" />

### News Page

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/8eb738dc-b2a4-4d66-bca8-f4dfcecc2501" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/96afbbf0-d5e6-42d1-8d29-8b3eab24cda0" />

### Achievement Page

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/a4cdf83e-9dc8-4296-ab7b-a575503b7687" />

### Facilities Page

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/08e1cbe3-c604-43d3-8623-ff9e78cea602" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1e21928a-9023-4717-b93a-7812077a75e0" />


### Forum Page

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/8dcc2ff3-bd90-4f94-88e0-f22fb02df288" />

<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/a6c9596b-6b58-4ec2-a666-7737407d2a93" />

---

## API Modules

* Authentication
* News
* Achievements
* Agendas
* Facilities
* Extracurricular Activities
* Forums
* Chats
* Job Listings
* Feedback

---

## Local Development Setup

### Prerequisites

* PHP 8+
* Composer
* MySQL
* Redis

### Installation

```bash
git clone https://github.com/rizqipratama25/skaneda-information-platform-api

cd skaneda-information-platform-api

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan serve
```

Application:

```bash
http://127.0.0.1:8000
```

---

## Key Takeaway

This project demonstrates how a seemingly simple school website can evolve into a multi-domain information platform requiring authentication, authorization, caching, queue processing, audit tracking, community features, and scalable API architecture.

---

## Frontend Integration

The frontend application was developed separately by a collaborator and consumes the APIs provided by this repository.

Frontend screenshots are included above to demonstrate how the APIs are used in a real application.
