


<x-back-end.master>
    @section('content')
            <!-- Dashboard Module -->
            <div id="dashboard" class="module p-6">
                <div class="section-title">Dashboard Overview</div>
                
                <div class="grid-4">
                    <div class="stat-card">
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value">2,543</div>
                        <div class="stat-change positive">↑ 12% from last month</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Courses</div>
                        <div class="stat-value">48</div>
                        <div class="stat-change positive">↑ 5 new courses</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">$45.2K</div>
                        <div class="stat-change positive">↑ 23% from last month</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Enrollments</div>
                        <div class="stat-value">8,234</div>
                        <div class="stat-change positive">↑ 18% from last month</div>
                    </div>
                </div>

                <div class="chart-container" style="margin-top: 2rem;">
                    <h3 style="margin-bottom: 1rem; font-weight: 600;">Revenue Trend</h3>
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>

                <div class="grid-2" style="margin-top: 2rem;">
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; font-weight: 600;">Enrollment Status</h3>
                        <canvas id="enrollmentChart" style="max-height: 250px;"></canvas>
                    </div>
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; font-weight: 600;">Course Distribution</h3>
                        <canvas id="courseChart" style="max-height: 250px;"></canvas>
                    </div>
                </div>

                <div class="chart-container" style="margin-top: 2rem;">
                    <h3 style="margin-bottom: 1rem; font-weight: 600;">Recent Activities</h3>
                    <div style="space-y: 1rem;">
                        <div style="padding: 1rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600;">New user registration</div>
                                <div style="font-size: 0.875rem; color: var(--text-secondary);">John Doe registered for Python Basics</div>
                            </div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">2 hours ago</div>
                        </div>
                        <div style="padding: 1rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600;">Payment received</div>
                                <div style="font-size: 0.875rem; color: var(--text-secondary);">$99.99 from Jane Smith</div>
                            </div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">4 hours ago</div>
                        </div>
                        <div style="padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-weight: 600;">Course completed</div>
                                <div style="font-size: 0.875rem; color: var(--text-secondary);">Mike Johnson completed Web Development</div>
                            </div>
                            <div style="font-size: 0.875rem; color: var(--text-secondary);">6 hours ago</div>
                        </div>
                    </div>
                </div>
            </div>

            

            <!-- Instructor Management Module -->
            <div id="instructor-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Instructor Management</div>
                    <button class="btn btn-primary" onclick="openModal('instructorModal')">+ Add Instructor</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Instructors</div>
                        <div class="stat-value">156</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Instructors</div>
                        <div class="stat-value">142</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Courses</div>
                        <div class="stat-value">348</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Rating</div>
                        <div class="stat-value">4.7★</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Students</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Dr. Alice Brown</td>
                                <td>alice@example.com</td>
                                <td>5</td>
                                <td>342</td>
                                <td>4.9★</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>Prof. Bob Wilson</td>
                                <td>bob@example.com</td>
                                <td>3</td>
                                <td>215</td>
                                <td>4.6★</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>Emma Davis</td>
                                <td>emma@example.com</td>
                                <td>7</td>
                                <td>521</td>
                                <td>4.8★</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            

            <!-- Course Management Module -->
            <div id="course-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Course Management</div>
                    <button class="btn btn-primary" onclick="openModal('courseModal')">+ Add Course</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Courses</div>
                        <div class="stat-value">348</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Published</div>
                        <div class="stat-value">312</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Draft</div>
                        <div class="stat-value">36</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Rating</div>
                        <div class="stat-value">4.6★</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Students</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Python Basics</td>
                                <td>Dr. Alice Brown</td>
                                <td>Programming</td>
                                <td>342</td>
                                <td>4.9★</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>Web Development</td>
                                <td>Prof. Bob Wilson</td>
                                <td>Programming</td>
                                <td>215</td>
                                <td>4.7★</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>UI/UX Design</td>
                                <td>Emma Davis</td>
                                <td>Design</td>
                                <td>521</td>
                                <td>4.8★</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Module Management Module -->
            <div id="module-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Module Management</div>
                    <button class="btn btn-primary" onclick="openModal('moduleModal')">+ Add Module</button>
                </div>

                <div class="grid-3" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Modules</div>
                        <div class="stat-value">892</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Published</div>
                        <div class="stat-value">856</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Draft</div>
                        <div class="stat-value">36</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>Course</th>
                                <th>Lessons</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Introduction to Python</td>
                                <td>Python Basics</td>
                                <td>8</td>
                                <td>4.5 hours</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>Variables & Data Types</td>
                                <td>Python Basics</td>
                                <td>6</td>
                                <td>3.2 hours</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Video Management Module -->
            <div id="video-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Video Management</div>
                    <button class="btn btn-primary" onclick="openModal('videoModal')">+ Add Video</button>
                </div>

                <div class="grid-3" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Videos</div>
                        <div class="stat-value">2,341</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Duration</div>
                        <div class="stat-value">1,234 hrs</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Views</div>
                        <div class="stat-value">542.3K</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Video Title</th>
                                <th>Module</th>
                                <th>Duration</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Getting Started with Python</td>
                                <td>Introduction to Python</td>
                                <td>12:34</td>
                                <td>1,234</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                            <tr>
                                <td>Setting Up Your Environment</td>
                                <td>Introduction to Python</td>
                                <td>8:45</td>
                                <td>892</td>
                                <td><span class="badge badge-success">Published</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enrollment Management Module -->
            <div id="enrollment-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Enrollment Management</div>
                    <button class="btn btn-primary" onclick="openModal('enrollmentModal')">+ Add Enrollment</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Enrollments</div>
                        <div class="stat-value">8,234</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active</div>
                        <div class="stat-value">6,892</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Completed</div>
                        <div class="stat-value">1,234</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Progress</div>
                        <div class="stat-value">62%</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Enrolled Date</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Python Basics</td>
                                <td>2024-01-15</td>
                                <td>75%</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Remove</button></td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>Web Development</td>
                                <td>2024-01-10</td>
                                <td>100%</td>
                                <td><span class="badge badge-info">Completed</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Remove</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Management Module -->
            <div id="payment-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Payment Management</div>
                    <button class="btn btn-primary" onclick="openModal('paymentModal')">+ Add Payment</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-value">$45.2K</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">This Month</div>
                        <div class="stat-value">$8.5K</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Transactions</div>
                        <div class="stat-value">1,234</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending</div>
                        <div class="stat-value">$2.3K</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#TXN001234</td>
                                <td>John Doe</td>
                                <td>Python Basics</td>
                                <td>$99.99</td>
                                <td>2024-01-15</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Refund</button></td>
                            </tr>
                            <tr>
                                <td>#TXN001235</td>
                                <td>Jane Smith</td>
                                <td>Web Development</td>
                                <td>$149.99</td>
                                <td>2024-01-14</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Refund</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Coupon Management Module -->
            <div id="coupon-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Coupon Management</div>
                    <button class="btn btn-primary" onclick="openModal('couponModal')">+ Add Coupon</button>
                </div>

                <div class="grid-3" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Coupons</div>
                        <div class="stat-value">45</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active</div>
                        <div class="stat-value">32</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Discount</div>
                        <div class="stat-value">$5.2K</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Coupon Code</th>
                                <th>Discount</th>
                                <th>Used</th>
                                <th>Limit</th>
                                <th>Expiry</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SAVE20</td>
                                <td>20%</td>
                                <td>45</td>
                                <td>100</td>
                                <td>2024-02-28</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">Delete</button></td>
                            </tr>
                            <tr>
                                <td>WELCOME10</td>
                                <td>10%</td>
                                <td>234</td>
                                <td>500</td>
                                <td>2024-03-31</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Discount Management Module -->
            <div id="discount-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Discount Management</div>
                    <button class="btn btn-primary" onclick="openModal('discountModal')">+ Add Discount</button>
                </div>

                <div class="grid-3" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Discounts</div>
                        <div class="stat-value">28</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active</div>
                        <div class="stat-value">18</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Saved</div>
                        <div class="stat-value">$12.5K</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Discount Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Applied To</th>
                                <th>Valid Until</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>New Year Sale</td>
                                <td>Percentage</td>
                                <td>25%</td>
                                <td>All Courses</td>
                                <td>2024-01-31</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Progress Management Module -->
            <div id="progress-management" class="module" style="display: none;">
                <div class="section-title">Progress Management</div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Progress Records</div>
                        <div class="stat-value">8,234</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Completion</div>
                        <div class="stat-value">62%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Completed</div>
                        <div class="stat-value">1,234</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-value">6,892</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Progress</th>
                                <th>Last Activity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Python Basics</td>
                                <td><div style="background: var(--bg-dark); border-radius: 9999px; height: 8px; width: 100px; overflow: hidden;"><div style="background: var(--success); height: 100%; width: 75%;"></div></div></td>
                                <td>2 hours ago</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quiz Management Module -->
            <div id="quiz-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Quiz Management</div>
                    <button class="btn btn-primary" onclick="openModal('quizModal')">+ Add Quiz</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Quizzes</div>
                        <div class="stat-value">156</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Questions</div>
                        <div class="stat-value">2,341</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Pass Rate</div>
                        <div class="stat-value">78%</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Total Attempts</div>
                        <div class="stat-value">12.5K</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Quiz Title</th>
                                <th>Course</th>
                                <th>Questions</th>
                                <th>Pass Rate</th>
                                <th>Attempts</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Python Basics Quiz</td>
                                <td>Python Basics</td>
                                <td>20</td>
                                <td>82%</td>
                                <td>234</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td><button class="btn btn-sm btn-secondary">Edit</button> <button class="btn btn-sm btn-secondary">View Results</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Certificate Management Module -->
            <div id="certificate-management" class="module" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <div class="section-title" style="margin-bottom: 0;">Certificate Management</div>
                    <button class="btn btn-primary" onclick="openModal('certificateModal')">+ Add Certificate</button>
                </div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Certificates</div>
                        <div class="stat-value">892</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Issued This Month</div>
                        <div class="stat-value">156</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Verified</div>
                        <div class="stat-value">856</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending</div>
                        <div class="stat-value">36</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Certificate ID</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Issued Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#CERT001234</td>
                                <td>Jane Smith</td>
                                <td>Web Development</td>
                                <td>2024-01-15</td>
                                <td><span class="badge badge-success">Verified</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Download</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Review Management Module -->
            <div id="review-management" class="module" style="display: none;">
                <div class="section-title">Review Management</div>

                <div class="grid-4" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Reviews</div>
                        <div class="stat-value">2,341</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Avg Rating</div>
                        <div class="stat-value">4.6★</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Pending Approval</div>
                        <div class="stat-value">45</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Flagged</div>
                        <div class="stat-value">12</div>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John Doe</td>
                                <td>Python Basics</td>
                                <td>5★</td>
                                <td>Excellent course! Very helpful.</td>
                                <td>2024-01-15</td>
                                <td><span class="badge badge-success">Approved</span></td>
                                <td><button class="btn btn-sm btn-secondary">View</button> <button class="btn btn-sm btn-secondary">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Analytics Module -->
            <div id="analytics" class="module" style="display: none;">
                <div class="section-title">Analytics & Reports</div>

                <div class="grid-2" style="margin-bottom: 2rem;">
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; font-weight: 600;">User Growth</h3>
                        <canvas id="userGrowthChart" style="max-height: 300px;"></canvas>
                    </div>
                    <div class="chart-container">
                        <h3 style="margin-bottom: 1rem; font-weight: 600;">Revenue Distribution</h3>
                        <canvas id="revenueDistributionChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>

                <div class="chart-container">
                    <h3 style="margin-bottom: 1rem; font-weight: 600;">Course Performance</h3>
                    <canvas id="coursePerformanceChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <!-- Settings Module -->
            <div id="settings" class="module" style="display: none;">
                <div class="section-title">Settings</div>

                <div class="stat-card" style="max-width: 600px;">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 600;">General Settings</h3>
                    
                    <div class="form-group">
                        <label class="form-label">Platform Name</label>
                        <input type="text" class="form-input" value="LMS Admin">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Support Email</label>
                        <input type="email" class="form-input" value="support@lms.com">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Currency</label>
                        <select class="form-input">
                            <option>USD ($)</option>
                            <option>EUR (€)</option>
                            <option>GBP (£)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Timezone</label>
                        <select class="form-input">
                            <option>UTC</option>
                            <option>EST</option>
                            <option>PST</option>
                        </select>
                    </div>

                    <button class="btn btn-primary" style="margin-top: 1rem;">Save Settings</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    

    <div class="modal" id="instructorModal">
        <div class="modal-content">
            <div class="modal-header">
                <span>Add New Instructor</span>
                <button class="modal-close" onclick="closeModal('instructorModal')">✕</button>
            </div>
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-input" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label class="form-label">Specialization</label>
                <input type="text" class="form-input" placeholder="Enter specialization">
            </div>
            <button class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Add Instructor</button>
        </div>
    </div>

    

    <div class="modal" id="courseModal">
        <div class="modal-content">
            <div class="modal-header">
                <span>Add New Course</span>
                <button class="modal-close" onclick="closeModal('courseModal')">✕</button>
            </div>
            <div class="form-group">
                <label class="form-label">Course Name</label>
                <input type="text" class="form-input" placeholder="Enter course name">
            </div>
            <div class="form-group">
                <label class="form-label">Instructor</label>
                <select class="form-input">
                    <option>Select instructor</option>
                    <option>Dr. Alice Brown</option>
                    <option>Prof. Bob Wilson</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select class="form-input">
                    <option>Select category</option>
                    <option>Programming</option>
                    <option>Design</option>
                </select>
            </div>
            <button class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Add Course</button>
        </div>
    </div>
    @endsection
</x-back-end.master>