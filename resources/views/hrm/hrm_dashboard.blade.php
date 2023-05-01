@include('new_layouts.header')
@include('hrm.hrm_main',['hrm_header' => 'Dashboard'])
 
<style>
#content {
    width: 100%;
    padding: 0;
    min-height: 100vh;
    transition: all 0.3s;
    margin: 0 33px 0 20px;
}

</style>
<div class="dash-container">
  <div class="dash-content">
    <div class="row">
      <div class="col-xxl-12">
        <div class="card">
          <div class="card-header">
            <h5>Today's Not Clock In</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row g-3 flex-nowrap team-lists horizontal-scroll-cards">
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-4.jpg" alt="">
                    <p class="mt-2">Mick Aston</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-11.jpg" alt="">
                    <p class="mt-2">Protiong</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-9.jpg" alt="">
                    <p class="mt-2">Cooper Decker</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/avatar.png" alt="">
                    <p class="mt-2">gjgjBrianna Copeland</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/avatar.png" alt="">
                    <p class="mt-2">kjh donald</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-5.jpg" alt="">
                    <p class="mt-2">Emma Hopper</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-1.jpg" alt="">
                    <p class="mt-2">Tara Hicks</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-7.jpg" alt="">
                    <p class="mt-2">Ralph Mercer</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h5>Event</h5>
                  </div>
                  <div class="col-lg-6">
                    <select class="form-control" name="calender_type" id="calender_type" style="float: right;width: 150px;" onchange="get_data()">
                      <option value="goggle_calender">Google Calender</option>
                      <option value="local_calender" selected="true">Local Calender</option>
                    </select>
                    <input type="hidden" id="event_dashboard" value="https://demo.rajodiya.com/erpgo">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="calendar" class="calendar local_calender fc fc-media-screen fc-direction-ltr fc-theme-bootstrap">
                  <div class="fc-header-toolbar fc-toolbar fc-toolbar-ltr">
                    <div class="fc-toolbar-chunk">
                      <div class="btn-group">
                        <button type="button" title="Previous month" aria-pressed="false" class="fc-prev-button btn btn-primary">
                          <span class="fa fa-chevron-left"></span>
                        </button>
                        <button type="button" title="Next month" aria-pressed="false" class="fc-next-button btn btn-primary">
                          <span class="fa fa-chevron-right"></span>
                        </button>
                      </div>
                      <button type="button" title="This month" disabled="" aria-pressed="false" class="fc-today-button btn btn-primary">today</button>
                    </div>
                    <div class="fc-toolbar-chunk">
                      <h2 class="fc-toolbar-title" id="fc-dom-1">April 2023</h2>
                    </div>
                    <div class="fc-toolbar-chunk">
                      <div class="btn-group">
                        <button type="button" title="Day view" aria-pressed="false" class="fc-timeGridDay-button btn btn-primary">Day</button>
                        <button type="button" title="Week view" aria-pressed="false" class="fc-timeGridWeek-button btn btn-primary">Week</button>
                        <button type="button" title="Month view" aria-pressed="true" class="fc-dayGridMonth-button btn btn-primary active">Month</button>
                      </div>
                    </div>
                  </div>
                  <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active" style="height: 533.333px;">
                    <div class="fc-daygrid fc-dayGridMonth-view fc-view">
                      <table role="grid" class="fc-scrollgrid table-bordered fc-scrollgrid-liquid">
                        <thead role="rowgroup">
                          <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                            <th role="presentation">
                              <div class="fc-scroller-harness">
                                <div class="fc-scroller" style="overflow: hidden;">
                                  <table role="presentation" class="fc-col-header " style="width: 717px;">
                                    <colgroup></colgroup>
                                    <thead role="presentation">
                                      <tr role="row">
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sun">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Sunday" class="fc-col-header-cell-cushion ">Sun</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-mon">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Monday" class="fc-col-header-cell-cushion ">Mon</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-tue">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Tuesday" class="fc-col-header-cell-cushion ">Tue</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-wed">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Wednesday" class="fc-col-header-cell-cushion ">Wed</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-thu">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Thursday" class="fc-col-header-cell-cushion ">Thu</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-fri">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Friday" class="fc-col-header-cell-cushion ">Fri</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sat">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Saturday" class="fc-col-header-cell-cushion ">Sat</a>
                                          </div>
                                        </th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody role="rowgroup">
                          <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                            <td role="presentation">
                              <div class="fc-scroller-harness fc-scroller-harness-liquid">
                                <div class="fc-scroller fc-scroller-liquid-absolute" style="overflow: hidden auto;">
                                  <div class="fc-daygrid-body fc-daygrid-body-balanced " style="width: 717px;">
                                    <table role="presentation" class="fc-scrollgrid-sync-table" style="width: 717px; height: 475px;">
                                      <colgroup></colgroup>
                                      <tbody role="presentation">
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past fc-day-other" data-date="2023-03-26" aria-labelledby="fc-dom-2">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-2" class="fc-daygrid-day-number" title="Go to March 26, 2023" data-navlink="" tabindex="0">26</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past fc-day-other" data-date="2023-03-27" aria-labelledby="fc-dom-4">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-4" class="fc-daygrid-day-number" title="Go to March 27, 2023" data-navlink="" tabindex="0">27</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past fc-day-other" data-date="2023-03-28" aria-labelledby="fc-dom-6">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-6" class="fc-daygrid-day-number" title="Go to March 28, 2023" data-navlink="" tabindex="0">28</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past fc-day-other" data-date="2023-03-29" aria-labelledby="fc-dom-8">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-8" class="fc-daygrid-day-number" title="Go to March 29, 2023" data-navlink="" tabindex="0">29</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past fc-day-other" data-date="2023-03-30" aria-labelledby="fc-dom-10">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-10" class="fc-daygrid-day-number" title="Go to March 30, 2023" data-navlink="" tabindex="0">30</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past fc-day-other" data-date="2023-03-31" aria-labelledby="fc-dom-12">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-12" class="fc-daygrid-day-number" title="Go to March 31, 2023" data-navlink="" tabindex="0">31</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-01" aria-labelledby="fc-dom-14">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-14" class="fc-daygrid-day-number" title="Go to April 1, 2023" data-navlink="" tabindex="0">1</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-02" aria-labelledby="fc-dom-16">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-16" class="fc-daygrid-day-number" title="Go to April 2, 2023" data-navlink="" tabindex="0">2</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-03" aria-labelledby="fc-dom-18">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-18" class="fc-daygrid-day-number" title="Go to April 3, 2023" data-navlink="" tabindex="0">3</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-04" aria-labelledby="fc-dom-20">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-20" class="fc-daygrid-day-number" title="Go to April 4, 2023" data-navlink="" tabindex="0">4</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-05" aria-labelledby="fc-dom-22">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-22" class="fc-daygrid-day-number" title="Go to April 5, 2023" data-navlink="" tabindex="0">5</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-06" aria-labelledby="fc-dom-24">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-24" class="fc-daygrid-day-number" title="Go to April 6, 2023" data-navlink="" tabindex="0">6</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-07" aria-labelledby="fc-dom-26">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-26" class="fc-daygrid-day-number" title="Go to April 7, 2023" data-navlink="" tabindex="0">7</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-08" aria-labelledby="fc-dom-28">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-28" class="fc-daygrid-day-number" title="Go to April 8, 2023" data-navlink="" tabindex="0">8</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-09" aria-labelledby="fc-dom-30">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-30" class="fc-daygrid-day-number" title="Go to April 9, 2023" data-navlink="" tabindex="0">9</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-10" aria-labelledby="fc-dom-32">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-32" class="fc-daygrid-day-number" title="Go to April 10, 2023" data-navlink="" tabindex="0">10</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-11" aria-labelledby="fc-dom-34">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-34" class="fc-daygrid-day-number" title="Go to April 11, 2023" data-navlink="" tabindex="0">11</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-12" aria-labelledby="fc-dom-36">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-36" class="fc-daygrid-day-number" title="Go to April 12, 2023" data-navlink="" tabindex="0">12</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-13" aria-labelledby="fc-dom-38">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-38" class="fc-daygrid-day-number" title="Go to April 13, 2023" data-navlink="" tabindex="0">13</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-14" aria-labelledby="fc-dom-40">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-40" class="fc-daygrid-day-number" title="Go to April 14, 2023" data-navlink="" tabindex="0">14</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-15" aria-labelledby="fc-dom-42">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-42" class="fc-daygrid-day-number" title="Go to April 15, 2023" data-navlink="" tabindex="0">15</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-16" aria-labelledby="fc-dom-44">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-44" class="fc-daygrid-day-number" title="Go to April 16, 2023" data-navlink="" tabindex="0">16</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-17" aria-labelledby="fc-dom-46">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-46" class="fc-daygrid-day-number" title="Go to April 17, 2023" data-navlink="" tabindex="0">17</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-18" aria-labelledby="fc-dom-48">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-48" class="fc-daygrid-day-number" title="Go to April 18, 2023" data-navlink="" tabindex="0">18</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-19" aria-labelledby="fc-dom-50">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-50" class="fc-daygrid-day-number" title="Go to April 19, 2023" data-navlink="" tabindex="0">19</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-20" aria-labelledby="fc-dom-52">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-52" class="fc-daygrid-day-number" title="Go to April 20, 2023" data-navlink="" tabindex="0">20</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-21" aria-labelledby="fc-dom-54">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-54" class="fc-daygrid-day-number" title="Go to April 21, 2023" data-navlink="" tabindex="0">21</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-22" aria-labelledby="fc-dom-56">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-56" class="fc-daygrid-day-number" title="Go to April 22, 2023" data-navlink="" tabindex="0">22</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-23" aria-labelledby="fc-dom-58">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-58" class="fc-daygrid-day-number" title="Go to April 23, 2023" data-navlink="" tabindex="0">23</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-24" aria-labelledby="fc-dom-60">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-60" class="fc-daygrid-day-number" title="Go to April 24, 2023" data-navlink="" tabindex="0">24</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-25" aria-labelledby="fc-dom-62">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-62" class="fc-daygrid-day-number" title="Go to April 25, 2023" data-navlink="" tabindex="0">25</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-26" aria-labelledby="fc-dom-64">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-64" class="fc-daygrid-day-number" title="Go to April 26, 2023" data-navlink="" tabindex="0">26</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-27" aria-labelledby="fc-dom-66">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-66" class="fc-daygrid-day-number" title="Go to April 27, 2023" data-navlink="" tabindex="0">27</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-28" aria-labelledby="fc-dom-68">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-68" class="fc-daygrid-day-number" title="Go to April 28, 2023" data-navlink="" tabindex="0">28</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-29" aria-labelledby="fc-dom-70">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-70" class="fc-daygrid-day-number" title="Go to April 29, 2023" data-navlink="" tabindex="0">29</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-today " data-date="2023-04-30" aria-labelledby="fc-dom-72">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-72" class="fc-daygrid-day-number" title="Go to April 30, 2023" data-navlink="" tabindex="0">30</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future fc-day-other" data-date="2023-05-01" aria-labelledby="fc-dom-74">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-74" class="fc-daygrid-day-number" title="Go to May 1, 2023" data-navlink="" tabindex="0">1</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future fc-day-other" data-date="2023-05-02" aria-labelledby="fc-dom-76">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-76" class="fc-daygrid-day-number" title="Go to May 2, 2023" data-navlink="" tabindex="0">2</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future fc-day-other" data-date="2023-05-03" aria-labelledby="fc-dom-78">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-78" class="fc-daygrid-day-number" title="Go to May 3, 2023" data-navlink="" tabindex="0">3</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future fc-day-other" data-date="2023-05-04" aria-labelledby="fc-dom-80">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-80" class="fc-daygrid-day-number" title="Go to May 4, 2023" data-navlink="" tabindex="0">4</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future fc-day-other" data-date="2023-05-05" aria-labelledby="fc-dom-82">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-82" class="fc-daygrid-day-number" title="Go to May 5, 2023" data-navlink="" tabindex="0">5</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other" data-date="2023-05-06" aria-labelledby="fc-dom-84">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-84" class="fc-daygrid-day-number" title="Go to May 6, 2023" data-navlink="" tabindex="0">6</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Staff</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-users"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Staff</p>
                          <h4 class="mb-0 text-success">13</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Employee</p>
                          <h4 class="mb-0 text-primary">6</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Client</p>
                          <h4 class="mb-0 text-danger">7</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Job</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-award"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Jobs</p>
                          <h4 class="mb-0 text-success">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-check"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Active Job</p>
                          <h4 class="mb-0 text-primary">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-x"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Inactive Job </p>
                          <h4 class="mb-0 text-danger">0</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Training</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-users"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Training</p>
                          <h4 class="mb-0 text-success">2</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Trainer</p>
                          <h4 class="mb-0 text-primary">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-user-check"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Active Training</p>
                          <h4 class="mb-0 text-danger">1</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-secondary">
                          <i class="ti ti-user-minus"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Done Training</p>
                          <h4 class="mb-0 text-secondary">1</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5>Announcement List</h5>
              </div>
              <div class="card-body" style="min-height: 295px;">
                <div class="table-responsive">
                  <table class="table align-items-center">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                      </tr>
                    </thead>
                    <tbody class="list">
                      <tr>
                        <td>Sports Scream</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                      <tr>
                        <td>My New Businesss</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                      <tr>
                        <td>WE WANT TO EARN YOUR DEEPEST TRUST.</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5>Meeting schedule</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                      </tr>
                    </thead>
                    <tbody class="list">
                      <tr>
                        <td>Meeting 1</td>
                        <td>Feb 18, 2023</td>
                        <td>12:20 PM</td>
                      </tr>
                      <tr>
                        <td>Meeting 2</td>
                        <td>Mar 24, 2023</td>
                        <td>12:26 PM</td>
                      </tr>
                      <tr>
                        <td>Accusantium et</td>
                        <td>Mar 22, 2023</td>
                        <td>7:29 PM</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->
  </div>
</div>

</style>
<div class="dash-container">
  <div class="dash-content">
    <div class="row">
      <div class="col-xxl-12">
        <div class="card">
          <div class="card-header">
            <h5>Today's Not Clock In</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="row g-3 flex-nowrap team-lists horizontal-scroll-cards">
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-4.jpg" alt="">
                    <p class="mt-2">Mick Aston</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-11.jpg" alt="">
                    <p class="mt-2">Protiong</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-9.jpg" alt="">
                    <p class="mt-2">Cooper Decker</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/avatar.png" alt="">
                    <p class="mt-2">gjgjBrianna Copeland</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/uploads/avatar/avatar.png" alt="">
                    <p class="mt-2">kjh donald</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-5.jpg" alt="">
                    <p class="mt-2">Emma Hopper</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-1.jpg" alt="">
                    <p class="mt-2">Tara Hicks</p>
                  </div>
                  <div class="col-auto">
                    <img src="https://demo.rajodiya.com/erpgo/storage/user-7.jpg" alt="">
                    <p class="mt-2">Ralph Mercer</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-lg-6">
                    <h5>Event</h5>
                  </div>
                  <div class="col-lg-6">
                    <select class="form-control" name="calender_type" id="calender_type" style="float: right;width: 150px;" onchange="get_data()">
                      <option value="goggle_calender">Google Calender</option>
                      <option value="local_calender" selected="true">Local Calender</option>
                    </select>
                    <input type="hidden" id="event_dashboard" value="https://demo.rajodiya.com/erpgo">
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="calendar" class="calendar local_calender fc fc-media-screen fc-direction-ltr fc-theme-bootstrap">
                  <div class="fc-header-toolbar fc-toolbar fc-toolbar-ltr">
                    <div class="fc-toolbar-chunk">
                      <div class="btn-group">
                        <button type="button" title="Previous month" aria-pressed="false" class="fc-prev-button btn btn-primary">
                          <span class="fa fa-chevron-left"></span>
                        </button>
                        <button type="button" title="Next month" aria-pressed="false" class="fc-next-button btn btn-primary">
                          <span class="fa fa-chevron-right"></span>
                        </button>
                      </div>
                      <button type="button" title="This month" disabled="" aria-pressed="false" class="fc-today-button btn btn-primary">today</button>
                    </div>
                    <div class="fc-toolbar-chunk">
                      <h2 class="fc-toolbar-title" id="fc-dom-1">April 2023</h2>
                    </div>
                    <div class="fc-toolbar-chunk">
                      <div class="btn-group">
                        <button type="button" title="Day view" aria-pressed="false" class="fc-timeGridDay-button btn btn-primary">Day</button>
                        <button type="button" title="Week view" aria-pressed="false" class="fc-timeGridWeek-button btn btn-primary">Week</button>
                        <button type="button" title="Month view" aria-pressed="true" class="fc-dayGridMonth-button btn btn-primary active">Month</button>
                      </div>
                    </div>
                  </div>
                  <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active" style="height: 533.333px;">
                    <div class="fc-daygrid fc-dayGridMonth-view fc-view">
                      <table role="grid" class="fc-scrollgrid table-bordered fc-scrollgrid-liquid">
                        <thead role="rowgroup">
                          <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                            <th role="presentation">
                              <div class="fc-scroller-harness">
                                <div class="fc-scroller" style="overflow: hidden;">
                                  <table role="presentation" class="fc-col-header " style="width: 717px;">
                                    <colgroup></colgroup>
                                    <thead role="presentation">
                                      <tr role="row">
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sun">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Sunday" class="fc-col-header-cell-cushion ">Sun</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-mon">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Monday" class="fc-col-header-cell-cushion ">Mon</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-tue">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Tuesday" class="fc-col-header-cell-cushion ">Tue</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-wed">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Wednesday" class="fc-col-header-cell-cushion ">Wed</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-thu">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Thursday" class="fc-col-header-cell-cushion ">Thu</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-fri">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Friday" class="fc-col-header-cell-cushion ">Fri</a>
                                          </div>
                                        </th>
                                        <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sat">
                                          <div class="fc-scrollgrid-sync-inner">
                                            <a aria-label="Saturday" class="fc-col-header-cell-cushion ">Sat</a>
                                          </div>
                                        </th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody role="rowgroup">
                          <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                            <td role="presentation">
                              <div class="fc-scroller-harness fc-scroller-harness-liquid">
                                <div class="fc-scroller fc-scroller-liquid-absolute" style="overflow: hidden auto;">
                                  <div class="fc-daygrid-body fc-daygrid-body-balanced " style="width: 717px;">
                                    <table role="presentation" class="fc-scrollgrid-sync-table" style="width: 717px; height: 475px;">
                                      <colgroup></colgroup>
                                      <tbody role="presentation">
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past fc-day-other" data-date="2023-03-26" aria-labelledby="fc-dom-2">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-2" class="fc-daygrid-day-number" title="Go to March 26, 2023" data-navlink="" tabindex="0">26</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past fc-day-other" data-date="2023-03-27" aria-labelledby="fc-dom-4">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-4" class="fc-daygrid-day-number" title="Go to March 27, 2023" data-navlink="" tabindex="0">27</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past fc-day-other" data-date="2023-03-28" aria-labelledby="fc-dom-6">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-6" class="fc-daygrid-day-number" title="Go to March 28, 2023" data-navlink="" tabindex="0">28</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past fc-day-other" data-date="2023-03-29" aria-labelledby="fc-dom-8">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-8" class="fc-daygrid-day-number" title="Go to March 29, 2023" data-navlink="" tabindex="0">29</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past fc-day-other" data-date="2023-03-30" aria-labelledby="fc-dom-10">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-10" class="fc-daygrid-day-number" title="Go to March 30, 2023" data-navlink="" tabindex="0">30</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past fc-day-other" data-date="2023-03-31" aria-labelledby="fc-dom-12">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-12" class="fc-daygrid-day-number" title="Go to March 31, 2023" data-navlink="" tabindex="0">31</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-01" aria-labelledby="fc-dom-14">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-14" class="fc-daygrid-day-number" title="Go to April 1, 2023" data-navlink="" tabindex="0">1</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-02" aria-labelledby="fc-dom-16">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-16" class="fc-daygrid-day-number" title="Go to April 2, 2023" data-navlink="" tabindex="0">2</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-03" aria-labelledby="fc-dom-18">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-18" class="fc-daygrid-day-number" title="Go to April 3, 2023" data-navlink="" tabindex="0">3</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-04" aria-labelledby="fc-dom-20">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-20" class="fc-daygrid-day-number" title="Go to April 4, 2023" data-navlink="" tabindex="0">4</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-05" aria-labelledby="fc-dom-22">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-22" class="fc-daygrid-day-number" title="Go to April 5, 2023" data-navlink="" tabindex="0">5</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-06" aria-labelledby="fc-dom-24">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-24" class="fc-daygrid-day-number" title="Go to April 6, 2023" data-navlink="" tabindex="0">6</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-07" aria-labelledby="fc-dom-26">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-26" class="fc-daygrid-day-number" title="Go to April 7, 2023" data-navlink="" tabindex="0">7</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-08" aria-labelledby="fc-dom-28">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-28" class="fc-daygrid-day-number" title="Go to April 8, 2023" data-navlink="" tabindex="0">8</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-09" aria-labelledby="fc-dom-30">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-30" class="fc-daygrid-day-number" title="Go to April 9, 2023" data-navlink="" tabindex="0">9</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-10" aria-labelledby="fc-dom-32">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-32" class="fc-daygrid-day-number" title="Go to April 10, 2023" data-navlink="" tabindex="0">10</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-11" aria-labelledby="fc-dom-34">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-34" class="fc-daygrid-day-number" title="Go to April 11, 2023" data-navlink="" tabindex="0">11</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-12" aria-labelledby="fc-dom-36">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-36" class="fc-daygrid-day-number" title="Go to April 12, 2023" data-navlink="" tabindex="0">12</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-13" aria-labelledby="fc-dom-38">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-38" class="fc-daygrid-day-number" title="Go to April 13, 2023" data-navlink="" tabindex="0">13</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-14" aria-labelledby="fc-dom-40">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-40" class="fc-daygrid-day-number" title="Go to April 14, 2023" data-navlink="" tabindex="0">14</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-15" aria-labelledby="fc-dom-42">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-42" class="fc-daygrid-day-number" title="Go to April 15, 2023" data-navlink="" tabindex="0">15</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-16" aria-labelledby="fc-dom-44">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-44" class="fc-daygrid-day-number" title="Go to April 16, 2023" data-navlink="" tabindex="0">16</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-17" aria-labelledby="fc-dom-46">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-46" class="fc-daygrid-day-number" title="Go to April 17, 2023" data-navlink="" tabindex="0">17</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-18" aria-labelledby="fc-dom-48">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-48" class="fc-daygrid-day-number" title="Go to April 18, 2023" data-navlink="" tabindex="0">18</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-19" aria-labelledby="fc-dom-50">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-50" class="fc-daygrid-day-number" title="Go to April 19, 2023" data-navlink="" tabindex="0">19</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-20" aria-labelledby="fc-dom-52">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-52" class="fc-daygrid-day-number" title="Go to April 20, 2023" data-navlink="" tabindex="0">20</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-21" aria-labelledby="fc-dom-54">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-54" class="fc-daygrid-day-number" title="Go to April 21, 2023" data-navlink="" tabindex="0">21</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-22" aria-labelledby="fc-dom-56">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-56" class="fc-daygrid-day-number" title="Go to April 22, 2023" data-navlink="" tabindex="0">22</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-past" data-date="2023-04-23" aria-labelledby="fc-dom-58">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-58" class="fc-daygrid-day-number" title="Go to April 23, 2023" data-navlink="" tabindex="0">23</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-past" data-date="2023-04-24" aria-labelledby="fc-dom-60">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-60" class="fc-daygrid-day-number" title="Go to April 24, 2023" data-navlink="" tabindex="0">24</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-past" data-date="2023-04-25" aria-labelledby="fc-dom-62">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-62" class="fc-daygrid-day-number" title="Go to April 25, 2023" data-navlink="" tabindex="0">25</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-past" data-date="2023-04-26" aria-labelledby="fc-dom-64">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-64" class="fc-daygrid-day-number" title="Go to April 26, 2023" data-navlink="" tabindex="0">26</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-past" data-date="2023-04-27" aria-labelledby="fc-dom-66">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-66" class="fc-daygrid-day-number" title="Go to April 27, 2023" data-navlink="" tabindex="0">27</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-past" data-date="2023-04-28" aria-labelledby="fc-dom-68">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-68" class="fc-daygrid-day-number" title="Go to April 28, 2023" data-navlink="" tabindex="0">28</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-past" data-date="2023-04-29" aria-labelledby="fc-dom-70">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-70" class="fc-daygrid-day-number" title="Go to April 29, 2023" data-navlink="" tabindex="0">29</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr role="row">
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sun fc-day-today " data-date="2023-04-30" aria-labelledby="fc-dom-72">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-72" class="fc-daygrid-day-number" title="Go to April 30, 2023" data-navlink="" tabindex="0">30</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-mon fc-day-future fc-day-other" data-date="2023-05-01" aria-labelledby="fc-dom-74">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-74" class="fc-daygrid-day-number" title="Go to May 1, 2023" data-navlink="" tabindex="0">1</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-tue fc-day-future fc-day-other" data-date="2023-05-02" aria-labelledby="fc-dom-76">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-76" class="fc-daygrid-day-number" title="Go to May 2, 2023" data-navlink="" tabindex="0">2</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-wed fc-day-future fc-day-other" data-date="2023-05-03" aria-labelledby="fc-dom-78">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-78" class="fc-daygrid-day-number" title="Go to May 3, 2023" data-navlink="" tabindex="0">3</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-thu fc-day-future fc-day-other" data-date="2023-05-04" aria-labelledby="fc-dom-80">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-80" class="fc-daygrid-day-number" title="Go to May 4, 2023" data-navlink="" tabindex="0">4</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-fri fc-day-future fc-day-other" data-date="2023-05-05" aria-labelledby="fc-dom-82">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-82" class="fc-daygrid-day-number" title="Go to May 5, 2023" data-navlink="" tabindex="0">5</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                          <td role="gridcell" class="fc-daygrid-day fc-day fc-day-sat fc-day-future fc-day-other" data-date="2023-05-06" aria-labelledby="fc-dom-84">
                                            <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                              <div class="fc-daygrid-day-top">
                                                <a id="fc-dom-84" class="fc-daygrid-day-number" title="Go to May 6, 2023" data-navlink="" tabindex="0">6</a>
                                              </div>
                                              <div class="fc-daygrid-day-events">
                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                              </div>
                                              <div class="fc-daygrid-day-bg"></div>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Staff</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-users"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Staff</p>
                          <h4 class="mb-0 text-success">13</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Employee</p>
                          <h4 class="mb-0 text-primary">6</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Client</p>
                          <h4 class="mb-0 text-danger">7</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Job</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-award"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Jobs</p>
                          <h4 class="mb-0 text-success">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-check"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Active Job</p>
                          <h4 class="mb-0 text-primary">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-x"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Inactive Job </p>
                          <h4 class="mb-0 text-danger">0</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-12">
              <div class="card">
                <div class="card-body">
                  <h5>Training</h5>
                  <div class="row  mt-4">
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-primary">
                          <i class="ti ti-users"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Total Training</p>
                          <h4 class="mb-0 text-success">2</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6 my-3 my-sm-0">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-info">
                          <i class="ti ti-user"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Trainer</p>
                          <h4 class="mb-0 text-primary">4</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-danger">
                          <i class="ti ti-user-check"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Active Training</p>
                          <h4 class="mb-0 text-danger">1</h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="d-flex align-items-start mb-3">
                        <div class="theme-avtar bg-secondary">
                          <i class="ti ti-user-minus"></i>
                        </div>
                        <div class="ms-2">
                          <p class="text-muted text-sm mb-0">Done Training</p>
                          <h4 class="mb-0 text-secondary">1</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5>Announcement List</h5>
              </div>
              <div class="card-body" style="min-height: 295px;">
                <div class="table-responsive">
                  <table class="table align-items-center">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                      </tr>
                    </thead>
                    <tbody class="list">
                      <tr>
                        <td>Sports Scream</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                      <tr>
                        <td>My New Businesss</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                      <tr>
                        <td>WE WANT TO EARN YOUR DEEPEST TRUST.</td>
                        <td>Jul 21, 2021</td>
                        <td>Jul 21, 2021</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5>Meeting schedule</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table align-items-center">
                    <thead>
                      <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                      </tr>
                    </thead>
                    <tbody class="list">
                      <tr>
                        <td>Meeting 1</td>
                        <td>Feb 18, 2023</td>
                        <td>12:20 PM</td>
                      </tr>
                      <tr>
                        <td>Meeting 2</td>
                        <td>Mar 24, 2023</td>
                        <td>12:26 PM</td>
                      </tr>
                      <tr>
                        <td>Accusantium et</td>
                        <td>Mar 22, 2023</td>
                        <td>7:29 PM</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->
  </div>
</div>

@include('new_layouts.footer')
