State Design Pattern ဆိုတာ Gang of Four (GoF) ရဲ့ Behavioral Design Pattern တစ်ခု ဖြစ်ပါတယ်။

***သူ့ရဲ့ အဓိက ရည်ရွယ်ချက်ကတော့ Object တစ်ခုရဲ့ အတွင်းပိုင်း အခြေအနေ (State) ပြောင်းလဲသွားမှုပေါ် မူတည်ပြီး၊ သူ့ရဲ့ လုပ်ဆောင်ချက် (Behavior) တွေကိုပါ လိုက်လျောညီထွေဖြစ်အောင် အလိုအလျောက် ပြောင်းလဲပေးဖို့ ဖြစ်ပါတယ်။ ဒါ့အပြင် အခြေအနေတစ်ခုချင်းစီအတွက် Logic တွေကို သီးသန့် Class တစ်ခုစီအဖြစ် ခွဲထုတ်ပစ်လိုက်တာ ဖြစ်ပါတယ်။***

ရိုးရိုးရှင်းရှင်း ဥပမာပေးရရင် - အရောင်းစက် (Vending Machine) တစ်ခုကို မြင်ကြည့်ပါ။ သူတည်းမှာ အခြေအနေ (States) မျိုးစုံ ရှိနိုင်ပါတယ် -

- ပိုက်ဆံမထည့်ရသေးတဲ့ အခြေအနေ (NoMoneyState) -> ဒီအချိန်မှာ ပစ္စည်းရွေးတဲ့ ခလုတ်နှိပ်ရင် "ပိုက်ဆံ အရင်ထည့်ပါ" လို့ ပြလိမ့်မယ်။

- ပိုက်ဆံထည့်ပြီးသား အခြေအနေ (HasMoneyState) -> ဒီအချိန်မှာ ခလုတ်နှိပ်ရင် ပစ္စည်းကျလာလိမ့်မယ်။

- ပစ္စည်းကုန်နေတဲ့ အခြေအနေ (OutOfStockState) -> ပိုက်ဆံထည့်ပြီး ခလုတ်နှိပ်ရင်တောင် ပစ္စည်းမကျဘဲ ပိုက်ဆံပြန်အန်ပေးလိမ့်မယ်။

စက်ကတော့ တစ်ခုတည်းပါပဲ (Context)။ ဒါပေမဲ့ သူ ရောက်နေတဲ့ အခြေအနေ (State) ပေါ် မူတည်ပြီး ခလုတ်နှိပ်တဲ့ လုပ်ဆောင်ချက် (Behavior) က ကွဲပြားသွားတာ ဖြစ်ပါတယ်။

# PHP နဲ့ ရိုးရှင်းတဲ့ ဥပမာတစ်ခု ကြည့်ရအောင်

E-commerce မှာ အော်ဒါတစ်ခု တင်လိုက်တဲ့အခါ ဖြတ်သန်းရမယ့် အခြေအနေတွေကို ရေးကြည့်ပါမယ်။ (ဥပမာ - မှာယူခါစ Pending ကနေ ငွေချေပြီးရင် Paid ဖြစ်မယ်၊ ပြီးရင် ပစ္စည်းပို့လိုက်ရင် Shipped ဖြစ်မယ်)

## ၁။ State Interface ဆောက်ခြင်း

အခြေအနေတိုင်းမှာ လုပ်ဆောင်လို့ရမယ့် Action Methods တွေကို သတ်မှတ်ပေးရပါမယ်။

```
interface OrderState {
    public function proceedToNext(OrderContext $context);
    public function getStatus();
}
```

## ၂။ Concrete States (အခြေအနေတစ်ခုချင်းစီအတွက် Class သီးသန့်ခွဲထုတ်ခြင်း)

```
// အခြေအနေ ၁ - စောင့်ဆိုင်းဆဲ
class PendingState implements OrderState {
    public function proceedToNext(OrderContext $context) {
        // Pending ပြီးရင် Paid အခြေအနေသို့ ပြောင်းမယ်
        $context->setState(new PaidState());
    }
    public function getStatus() { return "Pending (Waiting for payment)"; }
}

// အခြေအနေ ၂ - ငွေချေပြီးသား
class PaidState implements OrderState {
    public function proceedToNext(OrderContext $context) {
        // Paid ပြီးရင် Shipped အခြေအနေသို့ ပြောင်းမယ်
        $context->setState(new ShippedState());
    }
    public function getStatus() { return "Paid (Preparing to ship)"; }
}

// အခြေအနေ ၃ - ပစ္စည်းပို့လိုက်ပြီ
class ShippedState implements OrderState {
    public function proceedToNext(OrderContext $context) {
        echo "Order is already shipped. Final stage reached!\n";
    }
    public function getStatus() { return "Shipped (On the way)"; }
}
```

## ၃။ Context (လက်ရှိ ဘယ်အခြေအနေ ရောက်နေလဲဆိုတာကို ထိန်းသိမ်းထားမည့် Class)

```
class OrderContext {
    private $state;

    public function __construct() {
        // အစဦးဆုံး အခြေအနေကို Pending လို့ သတ်မှတ်မယ်
        $this->state = new PendingState();
    }

    public function setState(OrderState $state) {
        $this->state = $state;
    }

    // လက်ရှိ အခြေအနေကို ကြည့်ခြင်း
    public function printStatus() {
        echo "Current Status: " . $this->state->getStatus() . "\n";
    }

    // နောက်တစ်ဆင့်သို့ ကူးပြောင်းခြင်း
    public function nextStep() {
        $this->state->proceedToNext($this);
    }
}
```

လက်တွေ့ အသုံးပြုပုံ (Client Code)

```
$order = new OrderContext();
$order->printStatus(); // Output: Pending (Waiting for payment)

// ငွေချေလိုက်ပြီမို့ နောက်တစ်ဆင့်တက်မယ်
$order->nextStep();
$order->printStatus(); // Output: Paid (Preparing to ship)

// ပစ္စည်းပို့လိုက်ပြီမို့ နောက်တစ်ဆင့် ထပ်တက်မယ်
$order->nextStep();
$order->printStatus(); // Output: Shipped (On the way)
```

# Laravel Framework မှာ State Pattern ကို ဘယ်လိုသုံးလဲ?

Laravel ရဲ့ Eloquent ORM မှာ ဒီ State Pattern ကို Database မှာရှိတဲ့ status record တွေနဲ့ တွဲဖက်ပြီး အဓိကနေရာ နှစ်ခုမှာ သုံးလေ့ရှိပါတယ်။

## ၁။ Custom State Transitions

ကျွန်တော်တို့ Controller ထဲမှာ if ($order->status == 'pending') ဆိုပြီး if-else တွေ အများကြီး ရေးမယ့်အစား အပေါ်က GoF အတိုင်း State Class တွေ ခွဲထုတ်ပြီး သန့်သန့်ရှင်းရှင်း ရေးလေ့ရှိပါတယ်။

```
// Order Controller ထဲတွင် အသုံးပြုပုံဥပမာ
public function advanceOrder($id)
{
    $orderModel = Order::find($id);

    // Database ထဲက status string ပေါ်မူတည်ပြီး State Class ကို ပြောင်းလဲသက်မှတ်ခြင်း
    $context = new OrderContext();
    if ($orderModel->status === 'paid') {
        $context->setState(new PaidState());
    }

    // နောက်တစ်ဆင့် ပြောင်းခိုင်းမယ်
    $context->nextStep();

    // ပြောင်းလဲသွားတဲ့ အခြေအနေသစ်ကို Database မှာ ပြန်သိမ်းမယ်
    $orderModel->status = $context->getCurrentStatusString();
    $orderModel->save();
}
```

## ၂။ Spatie Laravel-State Package (အသုံးအများဆုံး Library)

Laravel Ecosystem မှာ State Pattern ကို ပိုမိုကောင်းမွန်အောင် ပြင်ဆင်ပြီး အသင့်သုံးနိုင်အောင် လုပ်ပေးထားတဲ့ နာမည်ကြီး Package တစ်ခုရှိပါတယ်။ အဲဒါကတော့ spatie/laravel-state ပါပဲ။ သူကလည်း ဒီ GoF ရဲ့ State Pattern ကိုပဲ အခြေခံထားတာ ဖြစ်ပါတယ်။

```
// Model ထဲမှာ ရေးပုံ
use Spatie\ModelStates\HasStates;

class Order extends Model
{
    use HasStates;

    protected function registerStates(): void
    {
        $this->addState('status', OrderState::class)
            ->default(Pending::class)
            ->allowTransition(Pending::class, Paid::class)
            ->allowTransition(Paid::class, Shipped::class);
    }
}

// Controller ထဲမှာ လှမ်းသုံးပုံ
$order->status->transitionTo(Paid::class);
```

ဘာကြောင့် သုံးသင့်လဲ? (အကျိုးကျေးဇူးများ)

- Eliminate massive conditionals: ကုဒ်တွေထဲမှာ ရှုပ်ပွနေမယ့် if-else သို့မဟုတ် switch-case အရှည်ကြီးတွေကို ဖယ်ရှားပေးနိုင်ပါတယ်။

- Single Responsibility Principle: အခြေအနေတစ်ခုချင်းစီရဲ့ Logic တွေကို သီးခြား Class တစ်ခုစီထဲမှာပဲ စုစည်းထားလို့ ကုဒ်ပြင်ရတာ အရမ်းလွယ်ကူသွားပါတယ်။

- Open/Closed Principle: အနာဂတ်မှာ အခြေအနေအသစ်တစ်ခု (ဥပမာ - ReturnedState - ပစ္စည်းပြန်အမ်းခြင်း) ထပ်တိုးချင်ရင် ရှိပြီးသား Class တွေကို လိုက်မဖျက်ဘဲ Class အသစ်တစ်ခု ထပ်ဆောက်လိုက်ရုံပါပဲ။
